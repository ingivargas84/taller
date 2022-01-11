<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTransaccionCargoAbono extends Model
{
    protected $fillable = [
        'tipo_transaccion'
    ];

    //Agregar metodo para relacion con Cuentas por pagar
    public function cuentasPorPagar() {
        return $this->hasMany('App\CuentaPorPagarDetalle', 'tipo_transaccion_id');
    }
}
