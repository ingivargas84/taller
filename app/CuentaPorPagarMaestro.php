<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaPorPagarMaestro extends Model
{
    //
    protected $fillable = [
        'proveedor_id',
        'estado_id',
        'user_id'
    ];

    //Cuenta por pagar tiene un proveedor
    public function proveedor() {
        return $this->belongsTo('App\Proveedor');
    }

    //Tiene un estado activo o inactivo
    public function estado() {
        return $this->belongsTo('App\estados');
    }

    //Cuenta por pagar tiene un usuario
    public function user() {
        return $this->belongsTo('App\User');
    }

    //Agregar cuentas por pagar detalle
    public function detalles() {
        return $this->hasMany('App\CuentaPorPagarDetalle', 'cuenta_pagar_maestro_id');
    }
}
