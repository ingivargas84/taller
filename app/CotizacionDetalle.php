<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotizacionDetalle extends Model
{
    protected $table = 'cotizaciones_detalle';

    protected $fillable = [
        'producto_id',
        'servicio_id',
        'cantidad',
        'precio',
        'isProduct',
        'cotizacion_maestro_id',
        'subtotal',
        'estado_id',
    ];

    public function estado() {
        return $this->belongsTo('App\estados');
    }

    public function producto() {
        return $this->belongsTo('App\Producto');
    }

    public function servicio() {
        return $this->belongsTo('App\Servicio');
    }

    public function cotizacion() {
        return $this->belongsTo('App\CotizacionMaestro');
    }
}
