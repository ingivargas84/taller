<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $table = 'visitas';

    protected $fillable = [
        'cliente_id',
        'nombre_cliente',
        'tipo_visita',
        'observaciones',
        'user_id',
        'estado'
    ];

    public function estado(){
        return $this->belongsTo('App\estados', 'estado');
    }

    public function cliente(){
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }


}
