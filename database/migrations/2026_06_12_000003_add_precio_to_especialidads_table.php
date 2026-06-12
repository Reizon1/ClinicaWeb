<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('especialidads', function (Blueprint $table) {
            $table->decimal('precio', 8, 2)->default(50.00)->after('descripcion');
        });

        // Set realistic default prices for existing specialties
        $precios = [
            'Cardiología'     => 120.00,
            'Medicina General' => 50.00,
            'Traumatología'   => 90.00,
            'Pediatría'       => 65.00,
            'Neurología'      => 110.00,
        ];

        foreach ($precios as $nombre => $precio) {
            DB::table('especialidads')->where('nombre', $nombre)->update(['precio' => $precio]);
        }
    }

    public function down(): void
    {
        Schema::table('especialidads', function (Blueprint $table) {
            $table->dropColumn('precio');
        });
    }
};
