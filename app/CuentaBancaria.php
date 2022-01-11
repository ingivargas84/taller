<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    protected $table = 'cuenta_bancarias';

    protected $fillable = [
        'nombre_cuenta',
        'no_cuenta',
        'banco_id',
        'tipo_cuenta_id',
        'estado_id'
    ];

    public function tipoCuenta() {
        return $this->belongsTo('App\TipoCuenta');
    }

    public function banco() {
        return $this->belongsTo('App\Banco');
    }

    public function estado() {
        return $this->belongsTo('App\estados');
    }

    public function cheques() {
        return $this->hasMany('App\Cheque', 'cuenta_bancaria_id');
    }
}
