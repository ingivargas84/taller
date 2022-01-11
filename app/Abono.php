<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    protected $fillable = [
        'fecha',
        'no_recibo',
        'anio',
        'documento_id',
        'no_documento',
        'total',
        'observaciones',
        'user_id'
    ];

    //Metodo. Un abono es hecho por un usuario
    public function user() {
        return $this->belongsTo('App\User');
    }

    //Metodo. Un abono tiene un documento
    public function documento() {
        return $this->belongsTo('App\Documento');
    }

    //Agregar metodo con Cuenta por pagar
    public function cuentaPorPagar() {
        return $this->hasOne('App\CuentaPorPagarDetalle', 'abono_id');
    }
    
}
