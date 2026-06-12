<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Especialidad::withCount('medicos');

        if ($request->filled('buscar')) {
            $query->whereRaw('nombre COLLATE utf8mb4_general_ci LIKE ?', ['%' . $request->buscar . '%']);
        }

        if ($request->has('activa') && $request->activa !== '') {
            $query->where('activa', (bool) $request->activa);
        }

        $especialidades = $query->orderBy('nombre')->paginate(15)->withQueryString();
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
            'precio'      => 'required|numeric|min:0|max:99999.99',
        ], [
            'nombre.required' => 'El nombre de la especialidad es obligatorio.',
            'nombre.unique'   => 'Esta especialidad ya existe.',
            'precio.required' => 'El precio de la consulta es obligatorio.',
            'precio.min'      => 'El precio debe ser mayor o igual a 0.',
        ]);

        Especialidad::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio'      => $request->precio,
            'activa'      => true,
        ]);

        return redirect()->route('admin.especialidades.index')->with('success', 'Especialidad creada correctamente.');
    }

    public function show(Especialidad $especialidad)
    {
        $especialidad->load(['medicos.user']);
        $totalCitas = $especialidad->citas()->count();
        return view('admin.especialidades.show', compact('especialidad', 'totalCitas'));
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
            'precio'      => 'required|numeric|min:0|max:99999.99',
        ], [
            'nombre.required' => 'El nombre de la especialidad es obligatorio.',
            'nombre.unique'   => 'Esta especialidad ya existe.',
            'precio.required' => 'El precio de la consulta es obligatorio.',
        ]);

        $especialidad->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio'      => $request->precio,
            'activa'      => $request->boolean('activa'),
        ]);

        return redirect()->route('admin.especialidades.index')->with('success', 'Especialidad actualizada correctamente.');
    }

    public function toggle(Especialidad $especialidad)
    {
        $especialidad->update(['activa' => !$especialidad->activa]);
        $estado = $especialidad->activa ? 'activada' : 'desactivada';
        return back()->with('success', "Especialidad «{$especialidad->nombre}» {$estado}.");
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
