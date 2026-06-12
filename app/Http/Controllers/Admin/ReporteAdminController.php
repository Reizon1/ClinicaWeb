<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Pago;
use App\Models\User;
use Illuminate\Http\Request;

class ReporteAdminController extends Controller
{
    public function index()
    {
        $anio = date('Y');

        $citasPorMes = Cita::selectRaw('MONTH(fecha_hora) as mes, COUNT(*) as total')
            ->whereYear('fecha_hora', $anio)
            ->groupBy('mes')
            ->pluck('total', 'mes');

        $datosPorMes = [];
        for ($m = 1; $m <= 12; $m++) {
            $datosPorMes[$m] = $citasPorMes[$m] ?? 0;
        }

        $topMedicos = Medico::with('user')
            ->withCount('citas')
            ->orderByDesc('citas_count')
            ->take(5)
            ->get();

        $citasPorEspecialidad = Especialidad::withCount('citas')
            ->orderByDesc('citas_count')
            ->take(6)
            ->get();

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

    public function pdfCitas(Request $request)
    {
        $desde = $request->get('desde', date('Y-01-01'));
        $hasta = $request->get('hasta', date('Y-12-31'));

        $citas = Cita::with(['paciente.user', 'medico.user', 'especialidad'])
            ->whereDate('fecha_hora', '>=', $desde)
            ->whereDate('fecha_hora', '<=', $hasta)
            ->orderBy('fecha_hora')
            ->get();

        $desdeLabel = \Carbon\Carbon::parse($desde)->format('d/m/Y');
        $hastaLabel = \Carbon\Carbon::parse($hasta)->format('d/m/Y');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.reporte_citas', [
            'citas'  => $citas,
            'desde'  => $desdeLabel,
            'hasta'  => $hastaLabel,
        ]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download("reporte-citas-{$desde}-{$hasta}.pdf");
    }

    public function pdfPacientes(Request $request)
    {
        $desde = $request->get('desde', date('Y-01-01'));
        $hasta = $request->get('hasta', date('Y-12-31'));

        $pacientes = Paciente::with(['user', 'suscripcionPremium'])
            ->withCount('citas')
            ->whereHas('user', fn($q) => $q->whereDate('created_at', '>=', $desde)
                                          ->whereDate('created_at', '<=', $hasta))
            ->orderBy('id')
            ->get();

        $desdeLabel = \Carbon\Carbon::parse($desde)->format('d/m/Y');
        $hastaLabel = \Carbon\Carbon::parse($hasta)->format('d/m/Y');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.reporte_pacientes', [
            'pacientes' => $pacientes,
            'desde'     => $desdeLabel,
            'hasta'     => $hastaLabel,
        ]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download("reporte-pacientes-{$desde}-{$hasta}.pdf");
    }

    public function pdfPagos(Request $request)
    {
        $desde = $request->get('desde', date('Y-01-01'));
        $hasta = $request->get('hasta', date('Y-12-31'));

        $pagos = Pago::with(['paciente.user', 'cita'])
            ->whereDate('fecha_pago', '>=', $desde)
            ->whereDate('fecha_pago', '<=', $hasta)
            ->orderBy('fecha_pago')
            ->get();

        $desdeLabel = \Carbon\Carbon::parse($desde)->format('d/m/Y');
        $hastaLabel = \Carbon\Carbon::parse($hasta)->format('d/m/Y');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.reporte_pagos', [
            'pagos' => $pagos,
            'desde' => $desdeLabel,
            'hasta' => $hastaLabel,
        ]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download("reporte-pagos-{$desde}-{$hasta}.pdf");
    }
}
