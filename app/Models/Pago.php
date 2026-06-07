<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'paciente_id',
        'cita_id',
        'concepto',
        'monto',
        'metodo_pago',              // 'paypal' | 'stripe' | 'efectivo'
        'estado',                   // 'pendiente' | 'completado' | 'fallido' | 'reembolsado'
        'referencia_transaccion',   // ID que devuelve PayPal o Stripe
        'fecha_pago',
    ];

    protected $casts = [
        'monto'      => 'decimal:2',    // siempre 2 decimales (ej: 45.00)
        'fecha_pago' => 'datetime',
    ];

    // ── Relaciones ────────────────────────────────────────────────

    // El pago PERTENECE a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // El pago corresponde a una cita (puede ser nulo)
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}
