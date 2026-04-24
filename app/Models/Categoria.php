<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'estado'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($categoria) {
            if (empty($categoria->codigo)) {
                $categoria->codigo = 'CAT-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }
}