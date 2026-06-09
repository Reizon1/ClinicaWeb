<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class MedicoDashboardController extends Controller
{
    public function agendaSemanal(Request $request)
    {
        $medico = auth()->user()->medico->load('especialidad');

        $inicioSemana = $request->filled('semana')
            ? Carbon::parse($request->semana)->startOfWeek(Carbon::MONDAY)
            : Carbon::now()->startOfWeek(Carbon::MONDAY);

        $finSemana = $inicioSemana->copy()->endOfWeek(Carbon::SUNDAY);

        $dias = collect(range(0, 6))->map(fn($i) => $inicioSemana->copy()->addDays($i));

        $citas = $medico->citas()
            ->with(['paciente.user', 'historialClinico', 'especialidad'])
            ->whereBetween('fecha_hora', [$inicioSemana->copy()->startOfDay(), $finSemana->copy()->endOfDay()])
            ->whereNotIn('estado', ['cancelada'])
            ->orderBy('fecha_hora')
            ->get()
            ->groupBy(fn($c) => $c->fecha_hora->format('Y-m-d'));

        $semanaPrev = $inicioSemana->copy()->subWeek()->format('Y-m-d');
        $semanaNext = $inicioSemana->copy()->addWeek()->format('Y-m-d');

        return view('medico.agenda-semanal', compact(
            'medico', 'citas', 'dias', 'inicioSemana', 'finSemana', 'semanaPrev', 'semanaNext'
        ));
    }

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
        $citasPendientes   = $medico->citas()
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->where('fecha_hora', '>=', now())
            ->count();

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
