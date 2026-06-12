<?php

namespace App\Http\Controllers;

class PacienteDashboardController extends Controller
{
    public function index()
    {
        $paciente = auth()->user()->paciente
            ?? \App\Models\Paciente::create(['user_id' => auth()->id()]);

        $proximaCita = $paciente->citas()
            ->with(['medico.user', 'especialidad'])
            ->whereIn('estado', ['confirmada', 'pendiente'])
            ->where('fecha_hora', '>=', now())
            ->orderBy('fecha_hora')
            ->first();

        $pagosPendientes = $paciente->pagos()
            ->where('estado', 'pendiente')
            ->get();

        $citasRecientes = $paciente->citas()
            ->with(['medico.user', 'especialidad', 'pago', 'historialClinico'])
            ->orderByDesc('fecha_hora')
            ->take(5)
            ->get();

        $suscripcion = $paciente->suscripcionPremium;

        return view('dashboards.paciente', compact(
            'paciente',
            'proximaCita',
            'pagosPendientes',
            'citasRecientes',
            'suscripcion'
        ));
    }

    public function misCitas()
    {
        $paciente = auth()->user()->paciente
            ?? \App\Models\Paciente::create(['user_id' => auth()->id()]);

        $proximasCitas = $paciente->citas()
            ->with(['medico.user', 'especialidad', 'pago'])
            ->where('fecha_hora', '>=', now())
            ->whereIn('estado', ['confirmada', 'pendiente'])
            ->orderBy('fecha_hora')
            ->get();

        $citasPasadas = $paciente->citas()
            ->with(['medico.user', 'especialidad', 'pago', 'historialClinico'])
            ->where(function ($q) {
                $q->where('fecha_hora', '<', now())
                  ->orWhereIn('estado', ['completada', 'cancelada']);
            })
            ->orderByDesc('fecha_hora')
            ->paginate(10);

        return view('paciente.citas', compact('paciente', 'proximasCitas', 'citasPasadas'));
    }

    public function historial()
    {
        $paciente = auth()->user()->paciente
            ?? \App\Models\Paciente::create(['user_id' => auth()->id()]);

        $historiales = $paciente->historialClinico()
            ->with(['medico.user', 'cita.especialidad'])
            ->orderByDesc('fecha')
            ->paginate(10);

        return view('paciente.historial', compact('paciente', 'historiales'));
    }

    public function misRecetas()
    {
        $paciente = auth()->user()->paciente
            ?? \App\Models\Paciente::create(['user_id' => auth()->id()]);

        $recetas = $paciente->recetas()
            ->with(['medico.user', 'cita.especialidad'])
            ->orderByDesc('fecha_emision')
            ->paginate(10);

        return view('paciente.recetas', compact('paciente', 'recetas'));
    }

    public function misPagos()
    {
        $paciente = auth()->user()->paciente
            ?? \App\Models\Paciente::create(['user_id' => auth()->id()]);

        // Upcoming appointments (confirmed/pending) without payment → advance payment
        $citasProximas = $paciente->citas()
            ->with(['medico.user', 'especialidad'])
            ->whereIn('estado', ['confirmada', 'pendiente'])
            ->where('fecha_hora', '>', now())
            ->whereDoesntHave('pago')
            ->orderBy('fecha_hora')
            ->get();

        // Completed appointments that have NO payment yet
        $citasSinPago = $paciente->citas()
            ->with(['medico.user', 'especialidad'])
            ->where('estado', 'completada')
            ->whereDoesntHave('pago')
            ->orderByDesc('fecha_hora')
            ->get();

        // Payments waiting for admin/receptionist approval
        $pagosEnRevision = $paciente->pagos()
            ->with(['cita.medico.user', 'cita.especialidad'])
            ->where('estado', 'pendiente')
            ->orderByDesc('created_at')
            ->get();

        // All other payments (approved, rejected, completed, etc.)
        $pagosHistorial = $paciente->pagos()
            ->with(['cita.medico.user', 'cita.especialidad'])
            ->where('estado', '!=', 'pendiente')
            ->orderByDesc('created_at')
            ->paginate(10);

        $totalPagado = $paciente->pagos()
            ->whereIn('estado', ['aprobado', 'completado'])
            ->sum('monto');

        return view('paciente.pagos', compact(
            'paciente', 'citasProximas', 'citasSinPago', 'pagosEnRevision', 'pagosHistorial', 'totalPagado'
        ));
    }
}
