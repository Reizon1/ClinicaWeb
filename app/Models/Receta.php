<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'cita_id',
        'medicamentos',     // JSON: [{nombre, dosis, frecuencia, dias}, ...]
        'indicaciones',
        'fecha_emision',
        'fecha_vencimiento',
    ];

    protected $casts = [
        // 'array' convierte automáticamente JSON ↔ array PHP al leer/escribir
        'medicamentos'      => 'array',
        'fecha_emision'     => 'date',
        'fecha_vencimiento' => 'date',
    ];

    // ── Relaciones ────────────────────────────────────────────────

    // La receta PERTENECE a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // La receta fue emitida por un médico
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    // La receta corresponde a una cita (puede ser nula)
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}
