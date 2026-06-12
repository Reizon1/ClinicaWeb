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
        'precio',
    ];

    protected $casts = [
        'activa' => 'boolean',
        'precio' => 'decimal:2',
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
