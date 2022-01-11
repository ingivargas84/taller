<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'documento'
    ];

    //Agregar metodo. Tipo de pago puede tener varios abonos
    public function abonos() {
        return $this->hasMany('App\Abono', 'documento_id');
    }
}
