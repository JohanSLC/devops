<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'categoria_id', 'marca', 'modelo', 
        'serie', 'estado', 'fecha_adquisicion', 'precio_adquisicion', 
        'ubicacion', 'observaciones', 'foto'
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date',
        'precio_adquisicion' => 'decimal:2'
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class);
    }

    public function mantenimientos(): HasMany
    {
        return $this->hasMany(Mantenimiento::class);
    }
}