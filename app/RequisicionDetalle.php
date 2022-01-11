<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisicionDetalle extends Model
{
    protected $table = 'requisicion_detalle';

    protected $fillable = [
        'requisicion_maestro_id',
        'insumo_id',
        'cantidad'
    ];
}
