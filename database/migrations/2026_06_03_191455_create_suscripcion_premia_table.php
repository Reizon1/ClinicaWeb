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
        Schema::create('suscripcion_premia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->string('plan')->default('premium');
            $table->decimal('precio', 8, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_vencimiento');
            $table->enum('estado', ['activa', 'vencida', 'cancelada'])->default('activa');
            $table->enum('metodo_pago', ['paypal', 'stripe']);
            $table->string('referencia_transaccion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suscripcion_premia');
    }
};
