<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisicionMaestro extends Model
{
    protected $table = 'requisicion_maestro';

    protected $fillable = [
        'user_id',
        'fecha_requisicion',
        'estado_requisicion_id',
        'user_rechaza',
        'razon_rechaza',
        'fecha_rechaza',
        'user_autoriza',
        'fecha_autoriza',
        'user_entrega',
        'fecha_entrega',
        'razon_entrega',
        'justificacion'
    ];
}
