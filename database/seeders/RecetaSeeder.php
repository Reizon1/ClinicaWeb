<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Receta;
use Illuminate\Database\Seeder;

class RecetaSeeder extends Seeder
{
    public function run(): void
    {
        // Recetas para las citas completadas (las 2 primeras)
        $citasCompletadas = Cita::where('estado', 'completada')->take(2)->get();

        $recetasData = [
            [
                // Receta de Quiroga para Carlos (hipertensión)
                'medicamentos' => [
                    ['nombre' => 'Losartán',    'dosis' => '50mg',  'frecuencia' => 'Una vez al día', 'dias' => 30],
                    ['nombre' => 'Atorvastatina','dosis' => '20mg', 'frecuencia' => 'Una vez al día', 'dias' => 30],
                ],
                'indicaciones'     => 'Tomar Losartán por la mañana con el desayuno. Evitar alimentos altos en sodio.',
                'fecha_emision'    => '2026-03-15',
                'fecha_vencimiento'=> '2026-04-15',
            ],
            [
                // Receta de Sánchez para Beatriz (diabetes)
                'medicamentos' => [
                    ['nombre' => 'Metformina', 'dosis' => '850mg', 'frecuencia' => 'Dos veces al día', 'dias' => 30],
                ],
                'indicaciones'     => 'Tomar Metformina con las comidas principales. Dieta estricta baja en azúcares.',
                'fecha_emision'    => '2026-03-10',
                'fecha_vencimiento'=> '2026-04-10',
            ],
        ];

        foreach ($citasCompletadas as $index => $cita) {
            Receta::create([
                'paciente_id'      => $cita->paciente_id,
                'medico_id'        => $cita->medico_id,
                'cita_id'          => $cita->id,
                'medicamentos'     => $recetasData[$index]['medicamentos'],
                'indicaciones'     => $recetasData[$index]['indicaciones'],
                'fecha_emision'    => $recetasData[$index]['fecha_emision'],
                'fecha_vencimiento'=> $recetasData[$index]['fecha_vencimiento'],
            ]);
        }
    }
}
