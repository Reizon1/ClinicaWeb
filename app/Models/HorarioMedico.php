<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioMedico extends Model
{
    protected $fillable = [
        'medico_id',
        'dia_semana',   // 'lunes' | 'martes' | ... | 'domingo'
        'hora_inicio',
        'hora_fin',
        'disponible',
    ];

    protected $casts = [
        'disponible' => 'boolean',
    ];

    // ── Relaciones ────────────────────────────────────────────────

    // Este horario PERTENECE a un médico
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}
