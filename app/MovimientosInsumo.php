<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientosInsumo extends Model
{
    protected $table = 'movimientos_insumos';
    
    protected $fillable = [
        'fecha_ingreso',
        'insumo_id',
        'existencias',
        'estado_id'
    ];
}
