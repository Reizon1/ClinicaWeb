<?php

namespace App\Http\Controllers;

use App\Models\HorarioMedico;
use Illuminate\Http\Request;

class HorarioMedicoController extends Controller
{
    private const DIAS = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];

    public function index()
    {
        $medico   = auth()->user()->medico;
        $horarios = $medico->horarios()
            ->orderByRaw("FIELD(dia_semana,'lunes','martes','miércoles','jueves','viernes','sábado','domingo')")
            ->get()
            ->groupBy('dia_semana');

        return view('horarios.index', compact('horarios', 'medico'));
    }

    public function create()
    {
        $dias = self::DIAS;
        return view('horarios.create', compact('dias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dia_semana'  => 'required|in:' . implode(',', self::DIAS),
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
        ], [
            'dia_semana.required'      => 'Seleccioná un día de la semana.',
            'dia_semana.in'            => 'El día seleccionado no es válido.',
            'hora_inicio.required'     => 'Indicá la hora de inicio.',
            'hora_inicio.date_format'  => 'Formato de hora inválido (usa HH:MM).',
            'hora_fin.required'        => 'Indicá la hora de fin.',
            'hora_fin.date_format'     => 'Formato de hora inválido (usa HH:MM).',
            'hora_fin.after'           => 'La hora de fin debe ser posterior a la de inicio.',
        ]);

        $medico = auth()->user()->medico;

        // Verificar solapamiento de horarios para ese médico en el mismo día
        $conflicto = HorarioMedico::where('medico_id', $medico->id)
            ->where('dia_semana', $request->dia_semana)
            ->where(function ($q) use ($request) {
                $q->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                  ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('hora_inicio', '<=', $request->hora_inicio)
                         ->where('hora_fin', '>=', $request->hora_fin);
                  });
            })->exists();

        if ($conflicto) {
            return back()
                ->withErrors(['hora_inicio' => 'Ya tenés un horario que se superpone en ese día y franja horaria.'])
                ->withInput();
        }

        HorarioMedico::create([
            'medico_id'   => $medico->id,
            'dia_semana'  => $request->dia_semana,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin'    => $request->hora_fin,
            'disponible'  => true,
        ]);

        return redirect()->route('horarios.index')->with('success', 'Horario agregado correctamente.');
    }

    public function destroy(HorarioMedico $horario)
    {
        abort_if($horario->medico_id !== auth()->user()->medico->id, 403);
        $horario->delete();
        return back()->with('success', 'Horario eliminado.');
    }
}
