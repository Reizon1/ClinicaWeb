<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Agrega 'recepcionista' al ENUM del campo 'rol' en la tabla users
        DB::statement("ALTER TABLE users MODIFY COLUMN rol ENUM('admin','medico','paciente','recepcionista') NOT NULL DEFAULT 'paciente'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN rol ENUM('admin','medico','paciente') NOT NULL DEFAULT 'paciente'");
    }
};
