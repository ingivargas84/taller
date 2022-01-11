<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValoresFijo extends Model
{
    protected $fillable = [
        'tipo'
    ];

    //
    public function movimiento() {
        return $this->hasOne('App\IngresoEgreso', 'campo_am_id');
    }
}
