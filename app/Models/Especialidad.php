<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    // Laravel generó la tabla como 'especialidads', la indicamos explícitamente
    protected $table = 'especialidads';

    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',  // convierte 0/1 de la BD a true/false en PHP
    ];

    // ── Relaciones ────────────────────────────────────────────────

    // Una especialidad tiene MUCHOS médicos
    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }

    // Una especialidad tiene MUCHAS citas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
