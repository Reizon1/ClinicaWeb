<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function checkout(Cita $cita)
    {
        $paciente = auth()->user()->paciente;

        abort_if($cita->paciente_id !== $paciente->id, 403);
        abort_if(
            !in_array($cita->estado, ['completada', 'confirmada', 'pendiente']),
            422,
            'Esta cita no está disponible para pago.'
        );

        if ($cita->pago) {
            return redirect()->route('paciente.pagos')->with('info', 'Esta cita ya tiene un pago registrado.');
        }

        $cita->load(['medico.user', 'especialidad']);

        $precioConsulta = $cita->especialidad->precio ?? 50.00;
        $qrImageUrl     = $this->resolveQrImageUrl();

        return view('pagos.checkout', compact('cita', 'qrImageUrl', 'precioConsulta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cita_id'     => 'required|exists:citas,id',
            'monto'       => 'required|numeric|min:0.01|max:99999.99',
            'metodo_pago' => 'required|in:qr,tarjeta,fisico',
            'comprobante' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:3072',
            'codigo_referencia' => 'nullable|string|max:100',
        ]);

        $paciente = auth()->user()->paciente;
        $cita     = Cita::findOrFail($request->cita_id);

        abort_if($cita->paciente_id !== $paciente->id, 403);
        abort_if(
            !in_array($cita->estado, ['completada', 'confirmada', 'pendiente']),
            422
        );
        abort_if($cita->pago()->exists(), 422, 'Esta cita ya tiene un pago.');

        $comprobantePath = null;
        if ($request->hasFile('comprobante')) {
            $comprobantePath = $request->file('comprobante')
                ->store('comprobantes', 'public');
        }

        $ultimoNumero  = Pago::whereNotNull('numero_factura')->count() + 1;
        $numeroFactura = 'FAC-' . date('Y') . '-' . str_pad($ultimoNumero, 5, '0', STR_PAD_LEFT);

        Pago::create([
            'paciente_id'       => $paciente->id,
            'cita_id'           => $cita->id,
            'concepto'          => 'Consulta ' . $cita->especialidad->nombre,
            'monto'             => $request->monto,
            'monto_original'    => $request->monto,
            'metodo_pago'       => $request->metodo_pago,
            'estado'            => 'pendiente',
            'comprobante_path'  => $comprobantePath,
            'codigo_referencia' => $request->codigo_referencia,
            'numero_factura'    => $numeroFactura,
            'fecha_pago'        => now(),
        ]);

        return redirect()->route('paciente.pagos')
            ->with('success', 'Pago registrado. Quedará pendiente hasta que sea aprobado.');
    }

    private function resolveQrImageUrl(): ?string
    {
        // Prefer the fixed path stored by QrConfigController
        if (Storage::disk('public')->exists('config/qr_fijo.png')) {
            return Storage::url('config/qr_fijo.png');
        }
        // Fallback: session value set by legacy uploadQR
        return session('cfg_qr_imagen', null);
    }
}
