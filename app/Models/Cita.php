<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'especialidad_id',
        'fecha_hora',
        'motivo',
        'estado',       // 'pendiente' | 'confirmada' | 'completada' | 'cancelada'
        'notas_medico',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',  // string → objeto Carbon con fecha y hora
    ];

    // ── Relaciones ────────────────────────────────────────────────

    // La cita PERTENECE a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // La cita PERTENECE a un médico
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    // La cita PERTENECE a una especialidad
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    // La cita tiene UN pago asociado
    public function pago()
    {
        return $this->hasOne(Pago::class);
    }

    // La cita tiene UN registro de historial clínico
    public function historialClinico()
    {
        return $this->hasOne(HistorialClinico::class);
    }

    // La cita tiene UNA receta emitida
    public function receta()
    {
        return $this->hasOne(Receta::class);
    }
}
