<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Producto;
use App\IngresoMaestro;
use App\MovimientoProducto;

class IngresoDetalle extends Model
{
    protected $table = 'ingresos_detalle';

    protected $fillable = [
            'fecha_ingreso',
            'producto_id',
            'precio_compra',
            'cantidad',
            'subtotal',
            'ingreso_maestro_id',
            'movimiento_producto_id',
            'estado_id'
    ];

    public function producto() {
        return $this->belongsTo('App\Producto');
    }

    public function ingresoMaestro() {
        return $this->belongsTo('App\IngresoMaestro');
    }

    public function movimientoProducto() {
        return $this->belongsTo('App\MovimientoProducto');
    }
}
