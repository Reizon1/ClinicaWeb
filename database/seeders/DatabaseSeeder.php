<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // El orden importa: cada seeder depende del anterior
        $this->call([
            EspecialidadSeeder::class,      // 1. Especialidades (sin dependencias)
            UserSeeder::class,              // 2. Usuarios con roles
            MedicoSeeder::class,            // 3. Perfiles médicos (necesita users + especialidades)
            PacienteSeeder::class,          // 4. Perfiles pacientes (necesita users)
            HorarioMedicoSeeder::class,     // 5. Horarios (necesita medicos)
            CitaSeeder::class,              // 6. Citas (necesita pacientes + medicos)
            HistorialClinicoSeeder::class,  // 7. Historial (necesita citas)
            RecetaSeeder::class,            // 8. Recetas (necesita citas)
            PagoSeeder::class,              // 9. Pagos (necesita citas)
        ]);
    }
}
