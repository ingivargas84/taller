<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';

    protected $fillable = [
        'id',
        'nombre_insumo',
        'tipo_insumo',
        'bodega',
        'existencias',
        'estado_id',
        'user_id'
    ];
}
