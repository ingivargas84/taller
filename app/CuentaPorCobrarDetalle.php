<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaPorCobrarDetalle extends Model
{
    protected $fillable = [
        'cuenta_cobrar_maestro_id',
        'tipo_transaccion_id',
        'fecha_transaccion',
        'credito_id',
        'abono_id',
        'total',
        'saldo',
        'user_id',
        'estado_id',
    ];

    //Cuenta por cobrar pertenece a un Credito/Orden de Trabajo
    public function credito() {
        return $this->belongsTo('App\OrdenEquipo', 'credito_id');
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

    //Pertenece a una cuenta por cobrar Maestro
    public function maestro() {
        return $this->belongsTo('App\CuentaPorCobrarMaestro', 'cuenta_cobrar_maestro_id');
    }
}
