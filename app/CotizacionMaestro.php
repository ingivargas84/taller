<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotizacionMaestro extends Model
{
    protected $table = "cotizaciones_maestro";

    protected $fillable = [
        'cliente_id',
        'no_cotizacion',
        'anio',
        'fecha',
        'total',
        'estado_id'
    ];

    public function estado() {
        return $this->belongsTo('App\estados');
    }

    public function cliente() {
        return $this->belongsTo('App\Cliente');
    }

    public function cotizacionesDetalle() {
        return $this->hasMany('App\CotizacionDetalle');
    }
}
