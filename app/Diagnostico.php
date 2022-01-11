<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $table = 'diagnosticos';

    protected $fillable = [
      'id',
      'codigo',
      'precio',
      'cantidad',
      'subtotal',
      'estado',
      'ordenequipo_id',
      'tipo',
      'nombre',
    ];
}
