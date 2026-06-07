<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $fillable = [
        'user_id',
        'fecha_nacimiento',
        'genero',
        'telefono',
        'direccion',
        'tipo_sangre',
        'alergias',
        'enfermedades_previas',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',   // string de BD → objeto Carbon (fecha)
    ];

    // ── Relaciones ────────────────────────────────────────────────

    // El paciente PERTENECE a un usuario (quien inicia sesión)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // El paciente tiene MUCHAS citas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    // El paciente tiene MUCHOS pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    // El paciente tiene MUCHOS registros de historial clínico
    public function historialClinico()
    {
        return $this->hasMany(HistorialClinico::class);
    }

    // El paciente tiene MUCHAS recetas
    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    // El paciente tiene UNA suscripción premium
    public function suscripcionPremium()
    {
        return $this->hasOne(SuscripcionPremium::class);
    }
}
