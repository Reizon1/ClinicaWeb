<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\HistorialClinico;
use Illuminate\Http\Request;

class HistorialClinicoController extends Controller
{
    public function index(Request $request)
    {
        $medico = auth()->user()->medico;

        $query = HistorialClinico::with(['paciente.user', 'cita'])
            ->where('medico_id', $medico->id)
            ->orderByDesc('fecha');

        if ($request->filled('buscar')) {
            $b = '%' . $request->buscar . '%';
            $query->whereHas('paciente.user', fn($q) => $q->where('name', 'like', $b));
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }

        $historiales = $query->paginate(15)->withQueryString();

        return view('historiales.index', compact('historiales'));
    }

    public function create(Request $request)
    {
        $medico = auth()->user()->medico;

        $citas = Cita::with('paciente.user')
            ->where('medico_id', $medico->id)
            ->whereIn('estado', ['confirmada', 'completada'])
            ->whereDoesntHave('historialClinico')
            ->orderByDesc('fecha_hora')
            ->get();

        $citaSeleccionada = $request->filled('cita_id') ? $citas->firstWhere('id', $request->cita_id) : null;

        return view('historiales.create', compact('citas', 'citaSeleccionada'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cita_id'       => 'required|exists:citas,id',
            'diagnostico'   => 'required|string|max:1000',
            'tratamiento'   => 'required|string|max:1000',
            'observaciones' => 'nullable|string|max:1000',
        ], [
            'cita_id.required'     => 'Seleccioná una cita.',
            'diagnostico.required' => 'El diagnóstico es obligatorio.',
            'tratamiento.required' => 'El tratamiento es obligatorio.',
        ]);

        $medico = auth()->user()->medico;
        $cita   = Cita::findOrFail($request->cita_id);

        abort_if($cita->medico_id !== $medico->id, 403);

        if ($cita->historialClinico()->exists()) {
            return back()->withErrors(['cita_id' => 'Esta cita ya tiene un historial clínico registrado.'])->withInput();
        }

        HistorialClinico::create([
            'paciente_id'   => $cita->paciente_id,
            'medico_id'     => $medico->id,
            'cita_id'       => $cita->id,
            'diagnostico'   => $request->diagnostico,
            'tratamiento'   => $request->tratamiento,
            'observaciones' => $request->observaciones,
            'fecha'         => $cita->fecha_hora->toDateString(),
        ]);

        $cita->update(['estado' => 'completada']);

        return redirect()->route('historiales.index')->with('success', 'Historial clínico registrado correctamente.');
    }

    public function show(HistorialClinico $historial)
    {
        abort_if($historial->medico_id !== auth()->user()->medico->id, 403);
        $historial->load(['paciente.user', 'cita', 'medico.especialidad', 'medico.user']);
        return view('historiales.show', compact('historial'));
    }

    public function edit(HistorialClinico $historial)
    {
        abort_if($historial->medico_id !== auth()->user()->medico->id, 403);
        $historial->load(['paciente.user', 'cita']);
        return view('historiales.edit', compact('historial'));
    }

    public function update(Request $request, HistorialClinico $historial)
    {
        abort_if($historial->medico_id !== auth()->user()->medico->id, 403);

        $request->validate([
            'diagnostico'   => 'required|string|max:1000',
            'tratamiento'   => 'required|string|max:1000',
            'observaciones' => 'nullable|string|max:1000',
        ], [
            'diagnostico.required' => 'El diagnóstico es obligatorio.',
            'tratamiento.required' => 'El tratamiento es obligatorio.',
        ]);

        $historial->update([
            'diagnostico'   => $request->diagnostico,
            'tratamiento'   => $request->tratamiento,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('historiales.index')
            ->with('success', 'Historial clínico actualizado correctamente.');
    }

    public function destroy(HistorialClinico $historial)
    {
        abort_if($historial->medico_id !== auth()->user()->medico->id, 403);
        $historial->delete();
        return back()->with('success', 'Historial clínico eliminado correctamente.');
    }
}
