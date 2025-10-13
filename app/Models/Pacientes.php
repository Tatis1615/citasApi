<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Pacientes extends Authenticatable{

    use HasApiTokens, Notifiable;
    protected $table = 'pacientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'documento',
        'telefono',
        'email',
        'fecha_nacimiento',
        'direccion',
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


    public function citas(){
        return $this->hasMany(Citas::class, 'paciente_id');
    }
}
