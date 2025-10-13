<?php

namespace App\Models;


use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Medicos extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'medicos';

    protected $fillable = [
        'especialidad_id',
        'consultorio_id',
        'nombre_m',
        'apellido_m',
        'edad',
        'telefono',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    /**
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function especialidades()
    {
        return $this->belongsTo(Especialidades::class, 'especialidad_id');
    }

    public function citas()
    {
        return $this->hasMany(Citas::class, 'medico_id');
    }

    public function consultorio()
    {
        return $this->belongsTo(Consultorios::class, 'consultorio_id');
    }
}
