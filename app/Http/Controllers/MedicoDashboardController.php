<?php

namespace App\Http\Controllers;

class MedicoDashboardController extends Controller
{
    public function index()
    {
        // Perfil del médico del usuario autenticado
        $medico = auth()->user()->medico->load('especialidad');

        // Todas las citas del médico para HOY
        $citasHoy = $medico->citas()
            ->with(['paciente.user', 'historialClinico'])
            ->whereDate('fecha_hora', today())
            ->orderBy('fecha_hora')
            ->get();

        // Estadísticas rápidas del día
        $totalCitasHoy     = $citasHoy->count();
        $citasAtendidas    = $citasHoy->where('estado', 'completada')->count();
        $citasPendientes   = $citasHoy->whereIn('estado', ['pendiente', 'confirmada'])->count();

        // Próxima cita futura del médico
        $proximaCita = $medico->citas()
            ->with(['paciente.user'])
            ->whereIn('estado', ['confirmada', 'pendiente'])
            ->where('fecha_hora', '>=', now())
            ->orderBy('fecha_hora')
            ->first();

        // Últimos 3 pacientes atendidos (sin duplicados)
        $pacientesRecientes = $medico->citas()
            ->with(['paciente.user'])
            ->where('estado', 'completada')
            ->orderByDesc('fecha_hora')
            ->take(10)
            ->get()
            ->pluck('paciente')
            ->unique('id')
            ->take(3);

        return view('dashboards.medico', compact(
            'medico',
            'citasHoy',
            'totalCitasHoy',
            'citasAtendidas',
            'citasPendientes',
            'proximaCita',
            'pacientesRecientes'
        ));
    }
}
