<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'precio',
        'estado_id'
    ];

    public function estado() {
        $this->belongsTo('App/estados');
    }

    public function cotizacionesDetalle() {
        return $this->hasMany('App\CotizacionDetalle');
    }
}
