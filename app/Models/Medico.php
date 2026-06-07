<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $fillable = [
        'user_id',
        'especialidad_id',
        'numero_licencia',
        'telefono',
        'descripcion',
        'foto',
        'disponible',
    ];

    protected $casts = [
        'disponible' => 'boolean',  // 0/1 en BD → true/false en PHP
    ];

    // ── Relaciones ────────────────────────────────────────────────

    // El médico PERTENECE a un usuario (quien inicia sesión)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // El médico PERTENECE a una especialidad (ej: Cardiología)
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    // El médico tiene MUCHOS horarios disponibles
    public function horarios()
    {
        return $this->hasMany(HorarioMedico::class);
    }

    // El médico tiene MUCHAS citas agendadas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    // El médico tiene MUCHOS registros de historial clínico generados
    public function historialClinico()
    {
        return $this->hasMany(HistorialClinico::class);
    }

    // El médico tiene MUCHAS recetas emitidas
    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }
}
