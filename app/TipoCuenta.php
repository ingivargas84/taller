<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCuenta extends Model
{
    protected $table = 'tipo_cuentas';

    protected $fillable = [
        'tipo'
    ];

    public function cuentas() {
        return $this->hasMany('App\CuentaBancaria', 'tipo_cuenta_id');
    }
}
