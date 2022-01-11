<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsumosMaestro extends Model
{
    protected $table = 'insumo_maestro';

    protected $fillable = [
        'user_id',
        'fecha_factura',
        'fecha_compra',
        'proveedor_id',
        'serie_factura',
        'num_factura',
        'total',
        'estado_id'
    ];
}
