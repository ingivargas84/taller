<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CajaDetalle extends Model
{
    protected $table = 'caja_detalles';

    protected $fillable = [
        'fecha',
        'descripcion',
        'total',
        'receptor',
        'isOpen',
        'anio',
        'numero',
        'isDeleted',
        'estado_id',
        'caja_maestro_id',
        'tipo_movimiento_id',
    ];

    public function cajaMaestro() {
        return $this->belongsTo('App\CajaMaestro');
    }

    public function estado() {
        return $this->belongsTo('App\estados');
    }
}
