<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCalculo extends Model
{
    protected $fillable = [
        'id',
        'tipo'
    ];

    //M'etodo, los tipos de ca'lculo tiene varios Ingresos Egresos
    public function movimientos() {
        return $this->hasMany('App\IngresoEgreso');
    }
}
