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
        'monto_original',
        'descuento_porcentaje',
        'beneficio_premium',
        'metodo_pago',              // 'qr'|'tarjeta'|'fisico'|'paypal'|'stripe'|'efectivo'
        'estado',                   // 'pendiente'|'aprobado'|'rechazado'|'completado'|'fallido'
        'referencia_transaccion',
        'comprobante_path',
        'codigo_referencia',
        'numero_factura',
        'fecha_pago',
    ];

    protected $casts = [
        'monto'                => 'decimal:2',
        'monto_original'       => 'decimal:2',
        'descuento_porcentaje' => 'decimal:2',
        'beneficio_premium'    => 'boolean',
        'fecha_pago'           => 'datetime',
    ];

    // ── Relaciones ────────────────────────────────────────────────

    // El pago PERTENECE a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Acceso directo al User a través del paciente (helper)
    public function user()
    {
        return $this->hasOneThrough(
            \App\Models\User::class,
            Paciente::class,
            'id',         // FK on pacientes
            'id',         // FK on users
            'paciente_id',
            'user_id'
        );
    }

    // El pago corresponde a una cita (puede ser nulo)
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    // Helper: is this payment considered "approved/complete"?
    public function estaAprobado(): bool
    {
        return in_array($this->estado, ['aprobado', 'completado']);
    }
}
