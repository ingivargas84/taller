<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipos_Detalles extends Model
{
    protected $table = 'equipos_detalles';

    protected $fillable = [
        'equipo_id',
        'tatuaje',
        'fecha_ingreso',
        'razon_ingreso',
        'user_ingreso',
        'fecha_salida',
        'razon_salida',
        'user_salida',
        'estado_computadora'
    ];
}
