<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoEnvio extends Model
{
    protected $table = 'estado_envios';

    protected $fillable = ['estado'];

    
    //relacion de registro de envio de equipo
    public function registroEnvio() {
        return $this->hasMany('App\RegistroEnvioEquipo');
    }
}
