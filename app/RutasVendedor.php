<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RutasVendedor extends Model
{
    protected $table = 'rutas_vendedors';

    protected $fillable = [
        'fecha',
        'no_orden',
        'cliente_id',
        'vendedor_id'
    ];

    public function vendedor() {
        return $this->belongsTo('App\Vendedor', 'vendedor_id');
    }

    public function cliente() {
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }

    //relacion orden trabajo
    public function ordenEquipo() {
        return $this->belongsTo('App\OrdenEquipo');
    }
}
