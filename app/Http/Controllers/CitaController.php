<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Especialidad;
use App\Models\Medico;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function create(Request $request)
    {
        $especialidades = Especialidad::where('activa', true)->orderBy('nombre')->get();

        // Si viene con especialidad_id pre-seleccionada cargamos sus médicos
        $medicos = collect();
        if ($request->filled('especialidad_id')) {
            $medicos = Medico::with('user')
                ->where('especialidad_id', $request->especialidad_id)
                ->where('disponible', true)
                ->get();
        } elseif ($request->filled('medico_id')) {
            // Si viene directo desde la tarjeta del médico, cargamos solo ese
            $medicos = Medico::with('user')
                ->where('id', $request->medico_id)
                ->where('disponible', true)
                ->get();
        }

        return view('citas.crear', compact('especialidades', 'medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'especialidad_id' => 'required|exists:especialidads,id',
            'medico_id'       => 'required|exists:medicos,id',
            'fecha_hora'      => 'required|date|after:now',
            'motivo'          => 'required|string|max:500',
        ], [
            'especialidad_id.required' => 'Seleccioná una especialidad.',
            'medico_id.required'       => 'Seleccioná un médico.',
            'fecha_hora.required'      => 'Indicá la fecha y hora de la cita.',
            'fecha_hora.after'         => 'La cita debe ser en una fecha futura.',
            'motivo.required'          => 'Describí el motivo de la consulta.',
        ]);

        $paciente = auth()->user()->paciente;

        Cita::create([
            'paciente_id'    => $paciente->id,
            'medico_id'      => $request->medico_id,
            'especialidad_id'=> $request->especialidad_id,
            'fecha_hora'     => $request->fecha_hora,
            'motivo'         => $request->motivo,
            'estado'         => 'pendiente',
        ]);

        return redirect()->route('dashboard.paciente')
            ->with('success', 'Cita agendada correctamente. Estará pendiente de confirmación.');
    }
}
