<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoOrdenTaller extends Model
{
    protected $table = 'estado_ordenes_trabajo';

    protected $fillable = [
        'id',
        'estado_orden_trabajo'
    ];
}
