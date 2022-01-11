<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovIngresoEgreso extends Model
{
    protected $fillable = [
        'id',
        'tipo'
    ];

    //Tipo tiene varios Ingresos Egresos
    public function movimientos() {
        return $this->hasMany('App\IngresoEgreso', 'tipo_movimiento_id');
    }
}
