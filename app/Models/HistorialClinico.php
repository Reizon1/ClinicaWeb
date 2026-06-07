<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialClinico extends Model
{
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'cita_id',
        'diagnostico',
        'tratamiento',
        'observaciones',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',   // string → objeto Carbon (solo fecha, sin hora)
    ];

    // ── Relaciones ────────────────────────────────────────────────

    // Este historial PERTENECE a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Este historial fue creado por un médico
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    // Este historial corresponde a una cita (puede ser nulo)
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}
