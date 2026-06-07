<?php

namespace Database\Seeders;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Database\Seeder;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = [
            [
                'email'               => 'carlos@email.com',
                'fecha_nacimiento'    => '1990-05-15',
                'genero'              => 'masculino',
                'telefono'            => '+1 (555) 310-1122',
                'direccion'           => 'Av. Principal 456, Ciudad Capital',
                'tipo_sangre'         => 'O+',
                'alergias'            => 'Penicilina',
                'enfermedades_previas'=> 'Hipertensión leve',
            ],
            [
                'email'               => 'ana@email.com',
                'fecha_nacimiento'    => '1995-08-22',
                'genero'              => 'femenino',
                'telefono'            => '+1 (555) 310-3344',
                'direccion'           => 'Calle Sur 123, Barrio Norte',
                'tipo_sangre'         => 'A+',
                'alergias'            => null,
                'enfermedades_previas'=> null,
            ],
            [
                'email'               => 'beatriz@email.com',
                'fecha_nacimiento'    => '1985-03-10',
                'genero'              => 'femenino',
                'telefono'            => '+1 (555) 310-5566',
                'direccion'           => 'Urb. Las Palmas, Casa 8',
                'tipo_sangre'         => 'B-',
                'alergias'            => 'Aspirina, Ibuprofeno',
                'enfermedades_previas'=> 'Diabetes tipo 2',
            ],
            [
                'email'               => 'roberto@email.com',
                'fecha_nacimiento'    => '1978-11-30',
                'genero'              => 'masculino',
                'telefono'            => '+1 (555) 310-7788',
                'direccion'           => 'Sector Industrial, Bloque C',
                'tipo_sangre'         => 'AB+',
                'alergias'            => null,
                'enfermedades_previas'=> 'Fractura de cadera (2020)',
            ],
            [
                'email'               => 'maria@email.com',
                'fecha_nacimiento'    => '2000-01-18',
                'genero'              => 'femenino',
                'telefono'            => '+1 (555) 310-9900',
                'direccion'           => 'Residencias Central, Apto 301',
                'tipo_sangre'         => 'O-',
                'alergias'            => null,
                'enfermedades_previas'=> null,
            ],
        ];

        foreach ($pacientes as $data) {
            $user = User::where('email', $data['email'])->first();

            Paciente::create([
                'user_id'              => $user->id,
                'fecha_nacimiento'     => $data['fecha_nacimiento'],
                'genero'               => $data['genero'],
                'telefono'             => $data['telefono'],
                'direccion'            => $data['direccion'],
                'tipo_sangre'          => $data['tipo_sangre'],
                'alergias'             => $data['alergias'],
                'enfermedades_previas' => $data['enfermedades_previas'],
            ]);
        }
    }
}
