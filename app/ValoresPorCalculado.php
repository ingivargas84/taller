<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValoresPorCalculado extends Model
{
    protected $fillable = [
        'dato'
    ];

    //
    public function movimiento() {
        return $this->hasOne('App\IngresoEgreso', 'campo_pc_id');
    }
}
