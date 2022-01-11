<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEnvio extends Model
{
    protected $table = 'tipo_envios';

    protected $fillable = [
      'id',
      'tipo_envio',
      'persona_recibe',
      'ordenequipo_id',
    ];
}
