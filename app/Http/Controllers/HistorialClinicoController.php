<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\HistorialClinico;
use App\Models\Paciente;
use Illuminate\Http\Request;

class HistorialClinicoController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = HistorialClinico::with(['paciente.user', 'medico.user', 'cita'])
            ->orderByDesc('fecha');

        // Doctors only see their own records; admin sees all
        if ($user->rol === 'medico') {
            $query->where('medico_id', $user->medico->id);
        }

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

    public function paciente(Paciente $paciente)
    {
        // All doctors + admin can see the full timeline for any patient
        $historiales = HistorialClinico::with(['medico.user', 'medico.especialidad', 'cita'])
            ->where('paciente_id', $paciente->id)
            ->orderByDesc('fecha')
            ->get();

        $paciente->load('user');

        return view('historiales.paciente', compact('historiales', 'paciente'));
    }

    public function show(HistorialClinico $historial)
    {
        $user = auth()->user();
        if ($user->rol === 'medico') {
            abort_if($historial->medico_id !== $user->medico->id, 403);
        }
        $historial->load(['paciente.user', 'cita', 'medico.especialidad', 'medico.user']);
        return view('historiales.show', compact('historial'));
    }

    public function edit(HistorialClinico $historial)
    {
        $user = auth()->user();
        abort_if($user->rol === 'admin', 403, 'Los administradores no pueden editar historiales directamente.');
        abort_if($historial->medico_id !== $user->medico->id, 403);
        $historial->load(['paciente.user', 'cita']);
        return view('historiales.edit', compact('historial'));
    }

    public function update(Request $request, HistorialClinico $historial)
    {
        $user = auth()->user();
        abort_if($user->rol === 'admin', 403);
        abort_if($historial->medico_id !== $user->medico->id, 403);

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
        $user = auth()->user();
        // Doctors cannot delete clinical records — only admins can
        abort_if($user->rol === 'medico', 403, 'Los médicos no pueden eliminar historiales clínicos.');
        $historial->delete();
        return back()->with('success', 'Historial clínico eliminado correctamente.');
    }
}
