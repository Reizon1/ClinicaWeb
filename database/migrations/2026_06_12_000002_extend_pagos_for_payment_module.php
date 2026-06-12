<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            // Voucher image path (QR comprobante uploaded by client)
            if (!Schema::hasColumn('pagos', 'comprobante_path')) {
                $table->string('comprobante_path')->nullable()->after('referencia_transaccion');
            }
            // Card/transfer reference code
            if (!Schema::hasColumn('pagos', 'codigo_referencia')) {
                $table->string('codigo_referencia')->nullable()->after('comprobante_path');
            }
        });

        // Extend metodo_pago enum to include new methods (keeps old for backward compat)
        DB::statement("ALTER TABLE pagos MODIFY COLUMN metodo_pago ENUM(
            'paypal','stripe','efectivo','qr','tarjeta','fisico'
        ) NOT NULL");

        // Extend estado enum to include aprobado/rechazado (keeps old for backward compat)
        DB::statement("ALTER TABLE pagos MODIFY COLUMN estado ENUM(
            'pendiente','completado','fallido','reembolsado','aprobado','rechazado'
        ) NOT NULL DEFAULT 'pendiente'");
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn(['comprobante_path', 'codigo_referencia']);
        });

        DB::statement("ALTER TABLE pagos MODIFY COLUMN metodo_pago ENUM('paypal','stripe','efectivo') NOT NULL");
        DB::statement("ALTER TABLE pagos MODIFY COLUMN estado ENUM('pendiente','completado','fallido','reembolsado') NOT NULL DEFAULT 'pendiente'");
    }
};
