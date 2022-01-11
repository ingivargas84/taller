<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_cliente extends Model
{
    protected $table = 'tipo_cliente';

    protected $fillable = [
        'id',
        'tipo_cliente'
    ];
}
