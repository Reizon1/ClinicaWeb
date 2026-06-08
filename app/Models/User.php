<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',                  // ── Estandarizado a 'role' como en tus rutas y vistas
        'two_factor_code',       // ── Campo para tus 6 dígitos de seguridad
        'two_factor_expires_at', // ── Campo para la expiración del 2FA
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'     => 'datetime',
            'password'              => 'hashed',
            'two_factor_expires_at' => 'datetime', // ── Cast de fecha para manipular con Carbon
        ];
    }

    // ── Relaciones (Avance de tu compañera) ───────────────────────────────────

    // El usuario tiene UN perfil de paciente
    public function paciente()
    {
        return $this->hasOne(Paciente::class);
    }

    // El usuario tiene UN perfil de médico
    public function medico()
    {
        return $this->hasOne(Medico::class);
    }

    // ── Helpers de rol (Sincronizados con 'role') ──────────────────────────────

    public function esPaciente(): bool
    {
        return $this->role === 'Paciente' || $this->role === 'paciente';
    }

    public function esMedico(): bool
    {
        return $this->role === 'Médico' || $this->role === 'medico';
    }

    public function esAdmin(): bool
    {
        return $this->role === 'Administrador' || $this->role === 'admin';
    }
}
