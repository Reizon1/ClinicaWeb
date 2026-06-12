<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Medico;
use Illuminate\Http\Request;

class AdminCitasController extends Controller
{
    public function index(Request $request)
    {
        $query = Cita::with(['paciente.user', 'medico.user', 'especialidad'])
            ->orderByDesc('fecha_hora');

        if ($request->filled('buscar')) {
            $b = '%' . $request->buscar . '%';
            $query->whereHas('paciente.user', fn($q) => $q->where('name', 'like', $b));
        }

        if ($request->filled('medico_id')) {
            $query->where('medico_id', $request->medico_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_hora', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_hora', '<=', $request->fecha_hasta);
        }

        $citas   = $query->paginate(25)->withQueryString();
        $medicos = Medico::with('user')->where('disponible', true)->get();

        $totalCitas       = Cita::count();
        $citasPendientes  = Cita::whereIn('estado', ['pendiente', 'confirmada'])->count();
        $citasCompletadas = Cita::where('estado', 'completada')->count();
        $citasCanceladas  = Cita::where('estado', 'cancelada')->count();

        return view('admin.citas.index', compact(
            'citas', 'medicos',
            'totalCitas', 'citasPendientes', 'citasCompletadas', 'citasCanceladas'
        ));
    }
}
