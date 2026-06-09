<?php

namespace App\Http\Controllers\Recepcionista;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
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

        return view('recepcionista.pagos.index', compact('pagos', 'pacientes', 'totalCompletado', 'totalPendiente'));
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

        $cita->load(['paciente.user', 'medico.user', 'especialidad']);

        return view('recepcionista.pagos.crear', compact('cita'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cita_id'     => 'required|exists:citas,id',
            'concepto'    => 'required|string|max:255',
            'monto'       => 'required|numeric|min:0.01|max:99999.99',
            'metodo_pago' => 'required|in:efectivo,stripe,paypal',
        ], [
            'concepto.required'    => 'El concepto es obligatorio.',
            'monto.required'       => 'El monto es obligatorio.',
            'monto.min'            => 'El monto debe ser mayor a 0.',
            'metodo_pago.required' => 'El método de pago es obligatorio.',
        ]);

        $cita = Cita::findOrFail($request->cita_id);

        Pago::create([
            'paciente_id' => $cita->paciente_id,
            'cita_id'     => $cita->id,
            'concepto'    => $request->concepto,
            'monto'       => $request->monto,
            'metodo_pago' => $request->metodo_pago,
            'estado'      => 'completado',
            'fecha_pago'  => now(),
        ]);

        return redirect()->route('recepcionista.pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }
}
