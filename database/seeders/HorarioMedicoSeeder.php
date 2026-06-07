<?php

namespace Database\Seeders;

use App\Models\HorarioMedico;
use App\Models\Medico;
use App\Models\User;
use Illuminate\Database\Seeder;

class HorarioMedicoSeeder extends Seeder
{
    public function run(): void
    {
        // Dr. Quiroga: Lunes a Viernes 8:00 - 14:00
        $quiroga = User::where('email', 'hquiroga@losmollos.com')->first()->medico;
        foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes'] as $dia) {
            HorarioMedico::create([
                'medico_id'   => $quiroga->id,
                'dia_semana'  => $dia,
                'hora_inicio' => '08:00',
                'hora_fin'    => '14:00',
                'disponible'  => true,
            ]);
        }

        // Dra. Sánchez: Lunes a Sábado 09:00 - 17:00
        $sanchez = User::where('email', 'msanchez@losmollos.com')->first()->medico;
        foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'] as $dia) {
            HorarioMedico::create([
                'medico_id'   => $sanchez->id,
                'dia_semana'  => $dia,
                'hora_inicio' => '09:00',
                'hora_fin'    => '17:00',
                'disponible'  => true,
            ]);
        }

        // Dr. Ramos: Martes, Jueves y Sábado 10:00 - 16:00
        $ramos = User::where('email', 'lramos@losmollos.com')->first()->medico;
        foreach (['martes', 'jueves', 'sabado'] as $dia) {
            HorarioMedico::create([
                'medico_id'   => $ramos->id,
                'dia_semana'  => $dia,
                'hora_inicio' => '10:00',
                'hora_fin'    => '16:00',
                'disponible'  => true,
            ]);
        }
    }
}
