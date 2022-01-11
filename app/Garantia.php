<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    protected $table = 'garantias';

    protected $fillable = [
        'no_garantia',
        'anio',
        'fecha',
        'estado_id',
        'cliente_id',
        'orden_equipo_id'
    ];

    public function cliente() {
        return $this->belongsTo('App\Cliente');
    }

    public function estado() {
        return $this->belongsTo('App\estado');
    }

    public function pedido() {
        return $this->belongsTo('App\OrdenEquipo');
    }
}
