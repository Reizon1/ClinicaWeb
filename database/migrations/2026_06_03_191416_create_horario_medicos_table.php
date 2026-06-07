<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('horario_medicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');
            $table->enum('dia_semana', ['lunes','martes','miercoles','jueves','viernes','sabado','domingo']);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_medicos');
    }
};
