<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'estado' => 'boolean',
        ];
    }

    // Métodos helper para verificar roles
    public function isAdmin(): bool
    {
        return $this->rol === 'Administrador';
    }

    public function isUsuario(): bool
    {
        return $this->rol === 'Usuario';
    }

    // ============ RELACIONES ============
    
    /**
     * Relación con movimientos
     */
    public function movimientos()
    {
        return $this->hasMany(\App\Models\Movimiento::class, 'usuario_id');
    }

    /**
     * Relación con mantenimientos
     */
    public function mantenimientos()
    {
        return $this->hasMany(\App\Models\Mantenimiento::class, 'usuario_id');
    }
}