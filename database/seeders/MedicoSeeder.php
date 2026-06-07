<?php

namespace Database\Seeders;

use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\User;
use Illuminate\Database\Seeder;

class MedicoSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos las especialidades por nombre para no depender del ID
        $cardiologia     = Especialidad::where('nombre', 'Cardiología')->first();
        $medicinaGeneral = Especialidad::where('nombre', 'Medicina General')->first();
        $traumatologia   = Especialidad::where('nombre', 'Traumatología')->first();

        $medicos = [
            [
                'email'           => 'hquiroga@losmollos.com',
                'especialidad_id' => $cardiologia->id,
                'numero_licencia' => 'MP-10245',
                'telefono'        => '+1 (555) 201-3344',
                'descripcion'     => 'Especialista en cardiología clínica con 15 años de experiencia. Egresado de la Universidad Central.',
                'disponible'      => true,
            ],
            [
                'email'           => 'msanchez@losmollos.com',
                'especialidad_id' => $medicinaGeneral->id,
                'numero_licencia' => 'MP-08833',
                'telefono'        => '+1 (555) 202-5566',
                'descripcion'     => 'Médica generalista con enfoque en medicina preventiva y atención familiar.',
                'disponible'      => true,
            ],
            [
                'email'           => 'lramos@losmollos.com',
                'especialidad_id' => $traumatologia->id,
                'numero_licencia' => 'MP-11567',
                'telefono'        => '+1 (555) 203-7788',
                'descripcion'     => 'Traumatólogo con especialización en cirugía de rodilla y cadera.',
                'disponible'      => true,
            ],
        ];

        foreach ($medicos as $data) {
            $user = User::where('email', $data['email'])->first();

            Medico::create([
                'user_id'         => $user->id,
                'especialidad_id' => $data['especialidad_id'],
                'numero_licencia' => $data['numero_licencia'],
                'telefono'        => $data['telefono'],
                'descripcion'     => $data['descripcion'],
                'disponible'      => $data['disponible'],
            ]);
        }
    }
}
