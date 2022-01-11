<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoMaestro extends Model
{
    protected $table = 'ingresos_maestro';

    protected $fillable = [
        'user_id',
        'fecha_factura',
        'fecha_compra',
        'proveedor_id',
        'serie_factura',
        'num_factura',
        'total',
        'estado_id'
    ];

    
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function proveedor() {
        return $this->belongsTo('App\Proveedor');
    }

    public function estado() {
        return $this->belongsTo('App\estados');
    }

    public function ingresosDetalle() {
        return $this->hasMany('App\IngresoDetalle');
    }

    //Una compra tiene una cuenta por Pagar
    public function cuentaPorPagar() {
        return $this->hasOne('App\CuentaPorPagarDetalle', 'compra_id');
    }

}
