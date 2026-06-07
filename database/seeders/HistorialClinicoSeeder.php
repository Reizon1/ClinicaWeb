<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\HistorialClinico;
use Illuminate\Database\Seeder;

class HistorialClinicoSeeder extends Seeder
{
    public function run(): void
    {
        // Solo las citas COMPLETADAS generan historial clínico
        $citasCompletadas = Cita::where('estado', 'completada')->get();

        $historiales = [
            [
                'diagnostico'  => 'Hipertensión arterial esencial controlada.',
                'tratamiento'  => 'Continuar Losartán 50mg, una vez al día.',
                'observaciones'=> 'Se recomienda dieta baja en sodio y actividad física moderada.',
            ],
            [
                'diagnostico'  => 'Diabetes mellitus tipo 2, control regular.',
                'tratamiento'  => 'Metformina 850mg dos veces al día. Dieta hipocalórica.',
                'observaciones'=> 'Próximo control en 30 días con ayunas.',
            ],
            [
                'diagnostico'  => 'Post-operatorio de prótesis de cadera total. Evolución favorable.',
                'tratamiento'  => 'Alta médica. Fisioterapia ambulatoria dos veces por semana.',
                'observaciones'=> 'Paciente puede retomar actividad laboral con restricciones.',
            ],
        ];

        foreach ($citasCompletadas as $index => $cita) {
            HistorialClinico::create([
                'paciente_id'  => $cita->paciente_id,
                'medico_id'    => $cita->medico_id,
                'cita_id'      => $cita->id,
                'diagnostico'  => $historiales[$index]['diagnostico'],
                'tratamiento'  => $historiales[$index]['tratamiento'],
                'observaciones'=> $historiales[$index]['observaciones'],
                'fecha'        => $cita->fecha_hora->toDateString(),
            ]);
        }
    }
}
