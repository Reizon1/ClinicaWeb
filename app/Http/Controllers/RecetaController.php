<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Receta;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    public function index(Request $request)
    {
        $medico = auth()->user()->medico;

        $query = Receta::with(['paciente.user', 'cita'])
            ->where('medico_id', $medico->id)
            ->orderByDesc('fecha_emision');

        if ($request->filled('buscar')) {
            $b = '%' . $request->buscar . '%';
            $query->whereHas('paciente.user', fn($q) => $q->where('name', 'like', $b));
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'vigente') {
                $query->whereDate('fecha_vencimiento', '>=', today());
            } elseif ($request->estado === 'vencida') {
                $query->whereDate('fecha_vencimiento', '<', today());
            }
        }

        $recetas = $query->paginate(15)->withQueryString();

        return view('recetas.index', compact('recetas'));
    }

    public function create(Request $request)
    {
        $medico = auth()->user()->medico;

        $citas = Cita::with('paciente.user')
            ->where('medico_id', $medico->id)
            ->whereIn('estado', ['confirmada', 'completada'])
            ->orderByDesc('fecha_hora')
            ->get();

        $citaSeleccionada = $request->filled('cita_id') ? $citas->firstWhere('id', $request->cita_id) : null;

        return view('recetas.create', compact('citas', 'citaSeleccionada'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cita_id'                       => 'required|exists:citas,id',
            'medicamentos'                  => 'required|array|min:1',
            'medicamentos.*.nombre'         => 'required|string|max:200',
            'medicamentos.*.dosis'          => 'required|string|max:100',
            'medicamentos.*.frecuencia'     => 'required|string|max:100',
            'medicamentos.*.dias'           => 'required|integer|min:1|max:365',
            'indicaciones'                  => 'nullable|string|max:1000',
            'fecha_vencimiento'             => 'required|date|after:today',
        ], [
            'cita_id.required'                   => 'Seleccioná una cita.',
            'medicamentos.required'              => 'Agregá al menos un medicamento.',
            'medicamentos.*.nombre.required'     => 'El nombre del medicamento es obligatorio.',
            'medicamentos.*.dosis.required'      => 'La dosis es obligatoria.',
            'medicamentos.*.frecuencia.required' => 'La frecuencia es obligatoria.',
            'medicamentos.*.dias.required'       => 'Los días de tratamiento son obligatorios.',
            'medicamentos.*.dias.min'            => 'Los días deben ser al menos 1.',
            'fecha_vencimiento.required'         => 'La fecha de vencimiento es obligatoria.',
            'fecha_vencimiento.after'            => 'La fecha de vencimiento debe ser posterior a hoy.',
        ]);

        $medico = auth()->user()->medico;
        $cita   = Cita::findOrFail($request->cita_id);

        abort_if($cita->medico_id !== $medico->id, 403);

        Receta::create([
            'paciente_id'       => $cita->paciente_id,
            'medico_id'         => $medico->id,
            'cita_id'           => $cita->id,
            'medicamentos'      => $request->medicamentos,
            'indicaciones'      => $request->indicaciones,
            'fecha_emision'     => today(),
            'fecha_vencimiento' => $request->fecha_vencimiento,
        ]);

        return redirect()->route('recetas.index')->with('success', 'Receta médica emitida correctamente.');
    }

    public function show(Receta $receta)
    {
        abort_if($receta->medico_id !== auth()->user()->medico->id, 403);
        $receta->load(['paciente.user', 'cita', 'medico.user', 'medico.especialidad']);
        return view('recetas.show', compact('receta'));
    }

    public function edit(Receta $receta)
    {
        abort_if($receta->medico_id !== auth()->user()->medico->id, 403);
        $receta->load(['paciente.user', 'cita']);
        return view('recetas.edit', compact('receta'));
    }

    public function update(Request $request, Receta $receta)
    {
        abort_if($receta->medico_id !== auth()->user()->medico->id, 403);

        $request->validate([
            'medicamentos'                  => 'required|array|min:1',
            'medicamentos.*.nombre'         => 'required|string|max:200',
            'medicamentos.*.dosis'          => 'required|string|max:100',
            'medicamentos.*.frecuencia'     => 'required|string|max:100',
            'medicamentos.*.dias'           => 'required|integer|min:1|max:365',
            'indicaciones'                  => 'nullable|string|max:1000',
            'fecha_vencimiento'             => 'required|date',
        ], [
            'medicamentos.required'              => 'Agregá al menos un medicamento.',
            'medicamentos.*.nombre.required'     => 'El nombre del medicamento es obligatorio.',
            'medicamentos.*.dosis.required'      => 'La dosis es obligatoria.',
            'medicamentos.*.frecuencia.required' => 'La frecuencia es obligatoria.',
            'medicamentos.*.dias.required'       => 'Los días de tratamiento son obligatorios.',
            'fecha_vencimiento.required'         => 'La fecha de vencimiento es obligatoria.',
        ]);

        $receta->update([
            'medicamentos'      => $request->medicamentos,
            'indicaciones'      => $request->indicaciones,
            'fecha_vencimiento' => $request->fecha_vencimiento,
        ]);

        return redirect()->route('recetas.index')
            ->with('success', 'Receta médica actualizada correctamente.');
    }

    public function destroy(Receta $receta)
    {
        abort_if($receta->medico_id !== auth()->user()->medico->id, 403);
        $receta->delete();
        return back()->with('success', 'Receta médica eliminada correctamente.');
    }
}
