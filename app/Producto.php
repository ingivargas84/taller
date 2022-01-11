<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable  = [
        'codigo',
        'nombre',
        'observaciones',
        'stock_minimo',
        'stock_maximo',
        'precio_venta',
        'estado_id'
    ];

    public function estado() {
        return $this->belongsTo('App/estados');
    }

    public function IngresosDetalle() {
        return $this->hasMany('App\IngresoDetalle');
    }

    public function cotizacionesDetalle() {
        return $this->hasMany('App\CotizacionDetalle');
    }
}
