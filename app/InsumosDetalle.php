<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsumosDetalle extends Model
{
    protected $table = 'insumo_detalle';

    protected $fillable = [
        'insumo_maestro_id',    
        'insumo_id',
        'precio_compra',
        'cantidad',
        'subtotal',
        'movimiento_insumo_id',
        'estado_id'
    ];
}
