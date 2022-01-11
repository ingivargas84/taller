<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model
{
    //
    protected $table = 'facturacions';

    protected $fillable = [
        'no_factura',
        'serie',
        'cliente',
        'nit',
        'direccion',
        'fecha',
        'monto',
        'eliminadaDesc',
        'cliente_id',
        'estado_id',
        'orden_id'

    ];

    public function clienteR() {
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }

    public function orden() {
        return $this->belongsTo('App\OrdenEquipo');
    }

    public function estado() {
        return $this->belongsTo('App\estados');
    }
}
