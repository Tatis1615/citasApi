<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultorios extends Model{
    protected $fillable = [
        'numero',
        'ubicacion',
    ];

    public function citas(){
        return $this->hasMany(Citas::class, 'consultorio_id');
    }

}
