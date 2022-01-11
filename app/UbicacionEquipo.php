<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\estados;

class UbicacionEquipo extends Model
{
    protected $table = 'ubicaciones_equipo';
    protected $fillable = [
        'ubicacion',
        'estado_id'
    ];

    public function estado() {
        return $this->belongsTo('App\estados');
    }

    public function equipos() {
        return $this->hasMany('App\Equipo', 'ubicacion_id');
    }
}
