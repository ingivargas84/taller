<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenEquipoLlamada extends Model
{
    protected $table = 'orden_equipo_llamadas';

    protected $fillable = [
      'id',
      'descripcion',
      'user_id',
      'ordenequipo_id',
      'created_at',
      'fecha',
      'hora',
    ];
}
