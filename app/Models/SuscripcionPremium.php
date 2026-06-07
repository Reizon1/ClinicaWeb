<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuscripcionPremium extends Model
{
    // La tabla se llama 'suscripcion_premia' (nombre generado por Laravel)
    protected $table = 'suscripcion_premia';

    protected $fillable = [
        'paciente_id',
        'plan',
        'precio',
        'fecha_inicio',
        'fecha_vencimiento',
        'estado',           // 'activa' | 'vencida' | 'cancelada'
        'metodo_pago',      // 'paypal' | 'stripe'
        'referencia_transaccion',
    ];

    protected $casts = [
        'precio'             => 'decimal:2',
        'fecha_inicio'       => 'date',
        'fecha_vencimiento'  => 'date',
    ];

    // ── Relaciones ────────────────────────────────────────────────

    // La suscripción PERTENECE a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // ── Helper ────────────────────────────────────────────────────

    // Retorna true si la suscripción está activa y no ha vencido
    public function estaActiva(): bool
    {
        return $this->estado === 'activa'
            && $this->fecha_vencimiento->isFuture();
    }
}
