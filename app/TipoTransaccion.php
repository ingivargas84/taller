<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTransaccion extends Model
{
    protected $table = 'tipo_transaccion';

    protected $fillable = [
        'tipo',
        'estado_id'
    ];

    public function estado() {
        return $this->belongsTo('App\estados');
    }

    public function estadoCuentaProveedor() {
        return $this->hasMany('App/EstadoCuentaProveedor');
    }
}
