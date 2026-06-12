<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->string('numero_factura')->nullable()->after('referencia_transaccion');
            $table->decimal('monto_original', 10, 2)->nullable()->after('monto');
            $table->decimal('descuento_porcentaje', 5, 2)->default(0)->after('monto_original');
            $table->boolean('beneficio_premium')->default(false)->after('descuento_porcentaje');
        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn(['numero_factura', 'monto_original', 'descuento_porcentaje', 'beneficio_premium']);
        });
    }
};
