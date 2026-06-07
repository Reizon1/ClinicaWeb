<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ─────────────────────────────────────────────────
        User::create([
            'name'     => 'Admin Los Mollos',
            'email'    => 'admin@losmollos.com',
            'password' => Hash::make('password'),
            'rol'      => 'admin',
        ]);

        // ── Médicos ───────────────────────────────────────────────
        User::create([
            'name'     => 'Hernán Quiroga',
            'email'    => 'hquiroga@losmollos.com',
            'password' => Hash::make('password'),
            'rol'      => 'medico',
        ]);

        User::create([
            'name'     => 'Marta Sánchez',
            'email'    => 'msanchez@losmollos.com',
            'password' => Hash::make('password'),
            'rol'      => 'medico',
        ]);

        User::create([
            'name'     => 'Luis Ramos',
            'email'    => 'lramos@losmollos.com',
            'password' => Hash::make('password'),
            'rol'      => 'medico',
        ]);

        // ── Pacientes ─────────────────────────────────────────────
        User::create([
            'name'     => 'Carlos Eduardo Pérez',
            'email'    => 'carlos@email.com',
            'password' => Hash::make('password'),
            'rol'      => 'paciente',
        ]);

        User::create([
            'name'     => 'Ana Paula Ruiz',
            'email'    => 'ana@email.com',
            'password' => Hash::make('password'),
            'rol'      => 'paciente',
        ]);

        User::create([
            'name'     => 'Beatriz Moreno',
            'email'    => 'beatriz@email.com',
            'password' => Hash::make('password'),
            'rol'      => 'paciente',
        ]);

        User::create([
            'name'     => 'Roberto Gómez',
            'email'    => 'roberto@email.com',
            'password' => Hash::make('password'),
            'rol'      => 'paciente',
        ]);

        User::create([
            'name'     => 'María Fernández',
            'email'    => 'maria@email.com',
            'password' => Hash::make('password'),
            'rol'      => 'paciente',
        ]);
    }
}
