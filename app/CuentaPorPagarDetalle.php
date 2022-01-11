<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaPorPagarDetalle extends Model
{
    protected $fillable = [
        'cuenta_pagar_maestro_id',
        'tipo_transaccion_id',
        'fecha_transaccion',
        'compra_id',
        'abono_id',
        'total',
        'saldo',
        'user_id',
        'estado_id',
    ];

    //Cuenta por pagar pertenece a una compra
    public function compra() {
        return $this->belongsTo('App\IngresoMaestro', 'compra_id');
    }

    //O pertenece a un abono
    public function abono() {
        return $this->belongsTo('App\Abono', 'abono_id');
    }

    //Tiene un tipo de transaccion
    public function tipoTransaccion() {
        return $this->belongsTo('App\TipoTransaccionCargoAbono', 'tipo_transaccion_id');
    }

    //Tiene un estado
    public function estado() {
        return $this->belongsTo('App\estados');
    }

    //Pertenece a una cuenta por pagar Maestro
    public function maestro() {
        return $this->belongsTo('App\CuentaPorPagarMaestro', 'cuenta_pagar_maestro_id');
    }
}
