<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoRequisicion extends Model
{
    protected $table = 'estado_requisicion';

    protected $fillable = [
        'estado_requisicion'
    ];
}
