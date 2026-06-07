<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Pago;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── KPIs globales ─────────────────────────────────────────
        $totalPacientes = Paciente::count();
        $medicosActivos = Medico::where('disponible', true)->count();
        $citasHoy       = Cita::whereDate('fecha_hora', today())->count();
        $ingresos       = Pago::where('estado', 'completado')->sum('monto');

        // ── Gráfico: citas por mes en el año actual ───────────────
        // Retorna colección con 'mes' (1-12) y 'total'
        $citasPorMes = Cita::selectRaw('MONTH(fecha_hora) as mes, COUNT(*) as total')
            ->whereYear('fecha_hora', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');   // ['1' => 5, '3' => 12, ...]

        // Convertimos a array de 12 posiciones (0 si no hay datos ese mes)
        $datosPorMes = [];
        for ($m = 1; $m <= 12; $m++) {
            $datosPorMes[$m] = $citasPorMes[$m] ?? 0;
        }

        // ── Últimas 5 citas (log del sistema) ────────────────────
        $ultimasCitas = Cita::with(['paciente.user', 'medico.user', 'especialidad'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // ── Últimos 3 pagos ───────────────────────────────────────
        $ultimosPagos = Pago::with(['paciente.user'])
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return view('dashboards.admin', compact(
            'totalPacientes',
            'medicosActivos',
            'citasHoy',
            'ingresos',
            'datosPorMes',
            'ultimasCitas',
            'ultimosPagos'
        ));
    }
}
