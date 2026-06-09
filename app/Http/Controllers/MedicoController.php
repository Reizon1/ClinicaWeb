<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Medico;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    // Endpoint JSON para el formulario de citas — devuelve medicos por especialidad
    public function porEspecialidad(Request $request)
    {
        $medicos = Medico::with('user')
            ->where('especialidad_id', $request->especialidad_id)
            ->where('disponible', true)
            ->get()
            ->map(fn($m) => ['id' => $m->id, 'nombre' => $m->user->name]);

        return response()->json($medicos);
    }

    public function buscar(Request $request)
    {
        $especialidades = Especialidad::where('activa', true)->orderBy('nombre')->get();

        $query = Medico::with(['user', 'especialidad'])
            ->where('disponible', true);

        if ($request->filled('especialidad_id')) {
            $query->where('especialidad_id', $request->especialidad_id);
        }

        if ($request->filled('nombre')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nombre . '%');
            });
        }

        $medicos = $query->get();

        return view('medicos.index', compact('medicos', 'especialidades'));
    }
}
