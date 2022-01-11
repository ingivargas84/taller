<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CajaMaestro extends Model
{
    protected $table = 'caja_maestros';

    protected $fillable = [
        'fecha',
        'saldo',
        'estado_caja_id',
    ];

    public function estadoCaja() {
        return $this->belongsTo('App\EstadoCaja');
    }

    public function cajaDetalles() {
        return $this->hasMany('App\CajaDetalle');
    }

}
