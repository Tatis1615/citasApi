<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Especialidades extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre_e',
        'descripcion'
    ];
    
    // Relación con médicos
    public function medicos()
    {
        return $this->hasMany(Medicos::class, 'especialidad_id');
    }
}