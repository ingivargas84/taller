<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    protected $table = 'tipo_movimientos';

    protected $fillable = [
        'tipo'
    ];

    public function cajaDetalles() {
        return $this->hasMany('App\CajaDetalle');
    }
}
