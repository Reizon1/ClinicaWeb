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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('cita_id')->nullable()->constrained('citas')->nullOnDelete();
            $table->string('concepto');                    // ej: "Consulta Cardiología"
            $table->decimal('monto', 8, 2);
            $table->enum('metodo_pago', ['paypal', 'stripe', 'efectivo']);
            $table->enum('estado', ['pendiente', 'completado', 'fallido', 'reembolsado'])->default('pendiente');
            $table->string('referencia_transaccion')->nullable(); // ID de PayPal / Stripe
            $table->dateTime('fecha_pago')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
