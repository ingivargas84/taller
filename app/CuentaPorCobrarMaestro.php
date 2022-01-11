<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaPorCobrarMaestro extends Model
{
    //
    protected $fillable = [
        'cliente_id',
        'estado_id',
        'total',
        'user_id'
    ];

    //Cuenta por cobrar tiene un cliente
    public function cliente() {
        return $this->belongsTo('App\Cliente');
    }

    //Tiene un estado activo o inactivo
    public function estado() {
        return $this->belongsTo('App\estados');
    }

    //Cuenta por cobrar tiene un usuario
    public function user() {
        return $this->belongsTo('App\User');
    }

    //Agregar cuentas por cobrar detalle
    public function detalles() {
        return $this->hasMany('App\CuentaPorCobrarDetalle', 'cuenta_cobrar_maestro_id');
    }
}
