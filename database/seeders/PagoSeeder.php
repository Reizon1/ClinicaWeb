<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Pago;
use Illuminate\Database\Seeder;

class PagoSeeder extends Seeder
{
    public function run(): void
    {
        // Pagos de citas completadas → estado 'completado'
        $citasCompletadas = Cita::where('estado', 'completada')->get();

        $pagosData = [
            ['concepto' => 'Consulta Cardiología',    'monto' => 75.00, 'metodo_pago' => 'stripe',   'referencia' => 'ch_3Pq1234ABCD'],
            ['concepto' => 'Consulta Medicina General','monto' => 45.00, 'metodo_pago' => 'paypal',   'referencia' => 'PAY-7XB123456'],
            ['concepto' => 'Consulta Traumatología',  'monto' => 80.00, 'metodo_pago' => 'efectivo', 'referencia' => null],
        ];

        foreach ($citasCompletadas as $index => $cita) {
            Pago::create([
                'paciente_id'            => $cita->paciente_id,
                'cita_id'                => $cita->id,
                'concepto'               => $pagosData[$index]['concepto'],
                'monto'                  => $pagosData[$index]['monto'],
                'metodo_pago'            => $pagosData[$index]['metodo_pago'],
                'estado'                 => 'completado',
                'referencia_transaccion' => $pagosData[$index]['referencia'],
                'fecha_pago'             => $cita->fecha_hora,
            ]);
        }

        // Pago PENDIENTE de una cita confirmada
        $citaConfirmada = Cita::where('estado', 'confirmada')->first();
        Pago::create([
            'paciente_id'            => $citaConfirmada->paciente_id,
            'cita_id'                => $citaConfirmada->id,
            'concepto'               => 'Consulta Cardiología',
            'monto'                  => 75.00,
            'metodo_pago'            => 'stripe',
            'estado'                 => 'pendiente',
            'referencia_transaccion' => null,
            'fecha_pago'             => null,
        ]);
    }
}
