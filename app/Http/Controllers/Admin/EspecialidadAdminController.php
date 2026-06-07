<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadAdminController extends Controller
{
    public function index()
    {
        $especialidades = Especialidad::withCount('medicos')->paginate(15);
        return view('admin.especialidades.index', compact('especialidades'));
    }

    public function create()
    {
        return view('admin.especialidades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100|unique:especialidads,nombre',
            'descripcion' => 'nullable|string|max:500',
        ], [
            'nombre.required' => 'El nombre de la especialidad es obligatorio.',
            'nombre.unique'   => 'Esta especialidad ya existe.',
        ]);

        Especialidad::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'activa'      => true,
        ]);

        return redirect()->route('admin.especialidades.index')->with('success', 'Especialidad creada correctamente.');
    }

    public function edit(Especialidad $especialidad)
    {
        return view('admin.especialidades.edit', compact('especialidad'));
    }

    public function update(Request $request, Especialidad $especialidad)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100|unique:especialidads,nombre,' . $especialidad->id,
            'descripcion' => 'nullable|string|max:500',
        ], [
            'nombre.required' => 'El nombre de la especialidad es obligatorio.',
            'nombre.unique'   => 'Esta especialidad ya existe.',
        ]);

        $especialidad->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'activa'      => $request->boolean('activa'),
        ]);

        return redirect()->route('admin.especialidades.index')->with('success', 'Especialidad actualizada correctamente.');
    }

    public function destroy(Especialidad $especialidad)
    {
        if ($especialidad->medicos()->count() > 0) {
            return back()->withErrors(['error' => 'No se puede eliminar una especialidad con médicos asignados.']);
        }
        $especialidad->delete();
        return back()->with('success', 'Especialidad eliminada.');
    }
}
