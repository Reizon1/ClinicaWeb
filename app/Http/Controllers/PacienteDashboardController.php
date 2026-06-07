<?php

namespace App\Http\Controllers;

class PacienteDashboardController extends Controller
{
    public function index()
    {
        // Perfil del paciente del usuario autenticado
        $paciente = auth()->user()->paciente;

        // Próxima cita confirmada o pendiente (la más cercana)
        $proximaCita = $paciente->citas()
            ->with(['medico.user', 'especialidad'])
            ->whereIn('estado', ['confirmada', 'pendiente'])
            ->where('fecha_hora', '>=', now())
            ->orderBy('fecha_hora')
            ->first();

        // Pagos pendientes de cobro
        $pagosPendientes = $paciente->pagos()
            ->where('estado', 'pendiente')
            ->get();

        // Últimas 5 citas (cualquier estado)
        $citasRecientes = $paciente->citas()
            ->with(['medico.user', 'especialidad'])
            ->orderByDesc('fecha_hora')
            ->take(5)
            ->get();

        // Suscripción premium activa (si tiene)
        $suscripcion = $paciente->suscripcionPremium;

        return view('dashboards.paciente', compact(
            'paciente',
            'proximaCita',
            'pagosPendientes',
            'citasRecientes',
            'suscripcion'
        ));
    }
}
