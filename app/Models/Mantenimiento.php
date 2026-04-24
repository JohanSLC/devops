<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos';
    
    protected $fillable = [
        'equipo_id', 
        'tipo', 
        'fecha_programada', 
        'fecha_realizada',
        'descripcion', 
        'observaciones', 
        'costo', 
        'tecnico', 
        'estado', 
        'usuario_id'
    ];

    protected $casts = [
        'fecha_programada' => 'date',
        'fecha_realizada' => 'date',
        'costo' => 'decimal:2'
    ];

    // ============ RELACIONES ============
    
    /**
     * Relación con equipo
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    /**
     * Relación con usuario (quien registró el mantenimiento)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}