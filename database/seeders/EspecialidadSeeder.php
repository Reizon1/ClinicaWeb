<?php

namespace Database\Seeders;

use App\Models\Especialidad;
use Illuminate\Database\Seeder;

class EspecialidadSeeder extends Seeder
{
    public function run(): void
    {
        $especialidades = [
            [
                'nombre'      => 'Cardiología',
                'descripcion' => 'Diagnóstico y tratamiento de enfermedades del corazón y sistema circulatorio.',
                'icono'       => 'heart',
                'activa'      => true,
            ],
            [
                'nombre'      => 'Medicina General',
                'descripcion' => 'Atención primaria, control de salud y enfermedades comunes.',
                'icono'       => 'stethoscope',
                'activa'      => true,
            ],
            [
                'nombre'      => 'Traumatología',
                'descripcion' => 'Lesiones del sistema musculoesquelético: huesos, músculos y articulaciones.',
                'icono'       => 'bone',
                'activa'      => true,
            ],
            [
                'nombre'      => 'Pediatría',
                'descripcion' => 'Atención médica integral para niños y adolescentes.',
                'icono'       => 'child',
                'activa'      => true,
            ],
            [
                'nombre'      => 'Neurología',
                'descripcion' => 'Enfermedades del sistema nervioso central y periférico.',
                'icono'       => 'brain',
                'activa'      => true,
            ],
        ];

        foreach ($especialidades as $especialidad) {
            Especialidad::create($especialidad);
        }
    }
}
