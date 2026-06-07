<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Pago;
use App\Models\User;

class ReporteAdminController extends Controller
{
    public function index()
    {
        $anio = date('Y');

        // Citas por mes del año actual
        $citasPorMes = Cita::selectRaw('MONTH(fecha_hora) as mes, COUNT(*) as total')
            ->whereYear('fecha_hora', $anio)
            ->groupBy('mes')
            ->pluck('total', 'mes');

        $datosPorMes = [];
        for ($m = 1; $m <= 12; $m++) {
            $datosPorMes[$m] = $citasPorMes[$m] ?? 0;
        }

        // Top 5 médicos con más citas
        $topMedicos = Medico::with('user')
            ->withCount('citas')
            ->orderByDesc('citas_count')
            ->take(5)
            ->get();

        // Citas por especialidad
        $citasPorEspecialidad = Especialidad::withCount('citas')
            ->orderByDesc('citas_count')
            ->take(6)
            ->get();

        // Resumen general
        $totalCitas       = Cita::count();
        $citasCompletadas = Cita::where('estado', 'completada')->count();
        $citasCanceladas  = Cita::where('estado', 'cancelada')->count();
        $citasPendientes  = Cita::whereIn('estado', ['pendiente', 'confirmada'])->count();
        $totalPagos       = Pago::where('estado', 'completado')->sum('monto');
        $totalPacientes   = Paciente::count();
        $totalMedicos     = Medico::where('disponible', true)->count();
        $totalUsuarios    = User::count();

        return view('admin.reportes.index', compact(
            'datosPorMes', 'topMedicos', 'citasPorEspecialidad',
            'totalCitas', 'citasCompletadas', 'citasCanceladas', 'citasPendientes',
            'totalPagos', 'totalPacientes', 'totalMedicos', 'totalUsuarios', 'anio'
        ));
    }
}
