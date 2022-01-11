<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UbicacionEquipo;
use App\estados;

class Equipo extends Model
{
    protected $table = 'equipos';

    protected $fillable = [
        'equipo',
        'descripcion',
        'estado_id',
        'ubicacion_id',
        'existencias'
    ];

    public function estado() {
        return $this->belongsTo('App\estados');
    }

    public function ubicacion() {
        return $this->belongsTo('App\UbicacionEquipo', 'ubicacion_id');
    }

    public function ordenEquipos() {
        return $this->hasMany('App\OrdenEquipo', 'equipo_id');
    }

}
