<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\estados;
class Vendedor extends Model
{
    protected $table = "vendedores";

    protected $fillable = [
        'nombres',
        'nit',
        'apellidos',
        'direccion',
        'celular',
        'correo',
        'comision',
        'estado_id',
    ];

    public function estado() {
        return $this->belongsTo('App\estados');
    }

    //rutas
    public function rutas() {
        return $this->hasMany('App\RutasVendedor', 'vendedor_id');
    }
}
