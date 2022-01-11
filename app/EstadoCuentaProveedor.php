<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoCuentaProveedor extends Model
{
    protected $table = 'estado_cuenta_proveedor';

    protected $fillable = [
        'proveedor_id',
        'documento_id',
        'transaccion_id',
        'estado_id',
        'total'
    ];

    public function proveedor() {
        return $this->belongsTo('App\Proveedor');
    }

    public function transaccion() {
        return $this->belongsTo('App\TipoTransaccion');
    }

    public function documento() {
        return $this->belongsTo('App\IngresoMaestro');
    } 

    public function estado() {
        return $this->belongsTo('App\estados');
    }
}
