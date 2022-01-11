<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\estados;

class TipoTrabajo extends Model
{
    protected $table = 'tipo_trabajos';

    protected $fillable = [
        'nombre',
        'estado_id'
    ];

    public function estado() {
        return $this->belongsTo('App\estados');
    }
}
