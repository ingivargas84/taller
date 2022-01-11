<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoProducto extends Model
{
    protected $table = 'movimientos_producto';
    
    protected $fillable = [

        'fecha_ingreso',
        'producto_id',
        'existencias',
        'precio_compra',
        'precio_venta',
        'estado_id'
    ];

    public function producto() {
        return $this->belongsTo('App\Producto');
    }

    
    public function estado() {
        return $this->belongsTo('App\estados');
    }

    public function ingresoDetalle() {
        return $this->hasOne('App\IngresoDetalle');
    }
}
