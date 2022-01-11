<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoCaja extends Model
{
    protected $table = 'estado_cajas';

    protected $fillable = [
        'estado'
    ];

    public function cajas() {
        return $this->hasMany('App\CajaMaestro');
    }
}
