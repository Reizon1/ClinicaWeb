<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    /**
     * Mostrar todas las especialidades (página pública)
     */
    public function index()
    {
        $especialidades = Especialidad::where('activa', true)
            ->with('medicos')
            ->get();

        return view('especialidades.index', compact('especialidades'));
    }

    /**
     * Mostrar detalles de una especialidad
     */
    public function show(Especialidad $especialidad)
    {
        $medicos = $especialidad->medicos()
            ->where('activo', true)
            ->get();

        return view('especialidades.show', compact('especialidad', 'medicos'));
    }
}
