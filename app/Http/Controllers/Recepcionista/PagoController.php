<?php

namespace App\Http\Controllers\Recepcionista;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    private const DESCUENTO_PREMIUM = 15; // 15% discount for premium subscribers

    public function index(Request $request)
    {
        $query = Pago::with(['paciente.user', 'cita.especialidad', 'cita.medico.user']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('paciente_id')) {
            $query->where('paciente_id', $request->paciente_id);
        }
        if ($request->filled('metodo_pago')) {
            $query->where('metodo_pago', $request->metodo_pago);
        }

        $pagos     = $query->orderByDesc('created_at')->paginate(20);
        $pacientes = Paciente::with('user')->orderBy('id')->get();

        $totalCompletado = Pago::where('estado', 'completado')->sum('monto');
        $totalPendiente  = Pago::where('estado', 'pendiente')->count();

        // Pending QR payments for admin approval notification
        $pagosPendientesQR = Pago::where('metodo_pago', 'qr')->where('estado', 'pendiente')->count();

        return view('recepcionista.pagos.index', compact(
            'pagos', 'pacientes', 'totalCompletado', 'totalPendiente', 'pagosPendientesQR'
        ));
    }

    public function create(Cita $cita)
    {
        if ($cita->estado !== 'completada') {
            return redirect()->route('recepcionista.citas')
                ->withErrors(['error' => 'Solo se puede registrar pago para citas completadas.']);
        }
        if ($cita->pago) {
            return redirect()->route('recepcionista.pagos.index')
                ->with('info', 'Esta cita ya tiene un pago registrado.');
        }

        $cita->load(['paciente.user', 'paciente.suscripcionPremium', 'medico.user', 'especialidad']);

        // Check premium status and calculate discount
        $suscripcion = $cita->paciente->suscripcionPremium;
        $esPremium   = $suscripcion && $suscripcion->estaActiva();
        $descuento   = $esPremium ? self::DESCUENTO_PREMIUM : 0;

        // Count premium appointments to check for reward
        $citasCompletadasPremium = 0;
        $beneficioDisponible = false;
        if ($esPremium) {
            $citasCompletadasPremium = Cita::where('paciente_id', $cita->paciente_id)
                ->where('estado', 'completada')
                ->whereHas('pago')
                ->count();
            // Next appointment (current) would be the nth
            $proximoNumero = $citasCompletadasPremium + 1;
            $beneficioDisponible = ($proximoNumero % 3 === 0);
        }

        // Get QR code image if configured
        $qrImagePath = session('cfg_qr_imagen', null);

        return view('recepcionista.pagos.crear', compact(
            'cita', 'esPremium', 'descuento', 'beneficioDisponible',
            'citasCompletadasPremium', 'qrImagePath'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cita_id'     => 'required|exists:citas,id',
            'concepto'    => 'required|string|max:255',
            'monto'       => 'required|numeric|min:0.01|max:99999.99',
            'metodo_pago' => 'required|in:efectivo,stripe,paypal,qr',
        ], [
            'concepto.required'    => 'El concepto es obligatorio.',
            'monto.required'       => 'El monto es obligatorio.',
            'monto.min'            => 'El monto debe ser mayor a 0.',
            'metodo_pago.required' => 'El método de pago es obligatorio.',
        ]);

        $cita = Cita::with(['paciente.suscripcionPremium'])->findOrFail($request->cita_id);

        // Check premium discount
        $suscripcion         = $cita->paciente->suscripcionPremium;
        $esPremium           = $suscripcion && $suscripcion->estaActiva();
        $descuentoPorcentaje = $esPremium ? self::DESCUENTO_PREMIUM : 0;
        $montoOriginal       = $request->monto;

        // Count for premium reward
        $beneficioPremium = false;
        if ($esPremium) {
            $citasCompletadas = Cita::where('paciente_id', $cita->paciente_id)
                ->where('estado', 'completada')
                ->whereHas('pago')
                ->count();
            $proximoNumero    = $citasCompletadas + 1;
            $beneficioPremium = ($proximoNumero % 3 === 0);
        }

        // Generate unique invoice number
        $ultimoNumero   = Pago::whereNotNull('numero_factura')->count() + 1;
        $numeroFactura  = 'FAC-' . date('Y') . '-' . str_pad($ultimoNumero, 5, '0', STR_PAD_LEFT);

        // QR payments start as pending; others as completed
        $estado = $request->metodo_pago === 'qr' ? 'pendiente' : 'completado';

        Pago::create([
            'paciente_id'          => $cita->paciente_id,
            'cita_id'              => $cita->id,
            'concepto'             => $request->concepto,
            'monto'                => $request->monto,
            'monto_original'       => $montoOriginal,
            'descuento_porcentaje' => $descuentoPorcentaje,
            'beneficio_premium'    => $beneficioPremium,
            'metodo_pago'          => $request->metodo_pago,
            'estado'               => $estado,
            'numero_factura'       => $numeroFactura,
            'fecha_pago'           => now(),
        ]);

        $mensaje = 'Pago registrado correctamente.';
        if ($esPremium && $descuentoPorcentaje > 0) {
            $mensaje .= " Se aplicó un descuento premium del {$descuentoPorcentaje}%.";
        }
        if ($beneficioPremium) {
            $mensaje .= ' ¡El paciente ha acumulado 3 citas premium y tiene un beneficio disponible!';
        }
        if ($estado === 'pendiente') {
            $mensaje = 'Pago por QR registrado. Pendiente de aprobación del administrador.';
        }

        return redirect()->route('recepcionista.pagos.index')->with('success', $mensaje);
    }

    public function factura(Pago $pago)
    {
        $pago->load(['paciente.user', 'cita.medico.user', 'cita.especialidad']);

        $clinica = [
            'nombre'    => session('cfg_nombre',    'Clínica Los Mollos'),
            'email'     => session('cfg_email',     'contacto@losmollos.com'),
            'telefono'  => session('cfg_telefono',  '+54 9 11 0000-0000'),
            'direccion' => session('cfg_direccion', 'Av. Principal 1234, Buenos Aires'),
        ];

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.factura', compact('pago', 'clinica'));
            return $pdf->download("factura-{$pago->numero_factura}.pdf");
        }

        return view('pdf.factura', compact('pago', 'clinica'));
    }
}
