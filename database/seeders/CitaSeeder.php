<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Database\Seeder;

class CitaSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos los perfiles por email para mayor claridad
        $quiroga = User::where('email', 'hquiroga@losmollos.com')->first()->medico;
        $sanchez = User::where('email', 'msanchez@losmollos.com')->first()->medico;
        $ramos   = User::where('email', 'lramos@losmollos.com')->first()->medico;

        $carlos  = User::where('email', 'carlos@email.com')->first()->paciente;
        $ana     = User::where('email', 'ana@email.com')->first()->paciente;
        $beatriz = User::where('email', 'beatriz@email.com')->first()->paciente;
        $roberto = User::where('email', 'roberto@email.com')->first()->paciente;
        $maria   = User::where('email', 'maria@email.com')->first()->paciente;

        $citas = [
            // Citas COMPLETADAS (historial existente)
            [
                'paciente_id'    => $carlos->id,
                'medico_id'      => $quiroga->id,
                'especialidad_id'=> $quiroga->especialidad_id,
                'fecha_hora'     => '2026-03-15 08:30:00',
                'motivo'         => 'Control de presión arterial y electrocardiograma de rutina.',
                'estado'         => 'completada',
                'notas_medico'   => 'Paciente estable. Se indica continuar tratamiento antihipertensivo.',
            ],
            [
                'paciente_id'    => $beatriz->id,
                'medico_id'      => $sanchez->id,
                'especialidad_id'=> $sanchez->especialidad_id,
                'fecha_hora'     => '2026-03-10 10:00:00',
                'motivo'         => 'Control glucémico mensual.',
                'estado'         => 'completada',
                'notas_medico'   => 'Glucemia en 145 mg/dl. Se ajusta dosis de metformina.',
            ],
            [
                'paciente_id'    => $roberto->id,
                'medico_id'      => $ramos->id,
                'especialidad_id'=> $ramos->especialidad_id,
                'fecha_hora'     => '2026-03-01 11:00:00',
                'motivo'         => 'Revisión de cadera post-operatoria.',
                'estado'         => 'completada',
                'notas_medico'   => 'Recuperación satisfactoria. Alta médica.',
            ],
            // Citas CONFIRMADAS (próximas)
            [
                'paciente_id'    => $carlos->id,
                'medico_id'      => $quiroga->id,
                'especialidad_id'=> $quiroga->especialidad_id,
                'fecha_hora'     => '2026-06-28 08:30:00',
                'motivo'         => 'Control mensual de cardiología.',
                'estado'         => 'confirmada',
                'notas_medico'   => null,
            ],
            [
                'paciente_id'    => $ana->id,
                'medico_id'      => $sanchez->id,
                'especialidad_id'=> $sanchez->especialidad_id,
                'fecha_hora'     => '2026-06-20 09:30:00',
                'motivo'         => 'Chequeo general anual.',
                'estado'         => 'confirmada',
                'notas_medico'   => null,
            ],
            // Citas PENDIENTES (por confirmar)
            [
                'paciente_id'    => $maria->id,
                'medico_id'      => $sanchez->id,
                'especialidad_id'=> $sanchez->especialidad_id,
                'fecha_hora'     => '2026-07-05 10:00:00',
                'motivo'         => 'Primera consulta. Dolor de cabeza frecuente.',
                'estado'         => 'pendiente',
                'notas_medico'   => null,
            ],
            // Cita CANCELADA
            [
                'paciente_id'    => $beatriz->id,
                'medico_id'      => $ramos->id,
                'especialidad_id'=> $ramos->especialidad_id,
                'fecha_hora'     => '2026-05-20 11:00:00',
                'motivo'         => 'Dolor en rodilla.',
                'estado'         => 'cancelada',
                'notas_medico'   => null,
            ],
        ];

        foreach ($citas as $cita) {
            Cita::create($cita);
        }
    }
}
