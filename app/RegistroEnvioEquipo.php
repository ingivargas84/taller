<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroEnvioEquipo extends Model
{
    protected $table = 'registro_envio_equipos';

    protected $fillable = [
        'no_envio',
        'orden_equipo_id',
        'empleado_id',
        'direccion',
        'observaciones',
        'receptor_equipo',
        'receptor_real',
        'estado_envio_id'
    ];
    //relacion de estado
    public function estadoEnvio() {
        return $this->belongsTo('App\EstadoEnvio');
    }
    // relacion de empleado
    public function empleado() {
        return $this->belongsTo('App\Empleado');
    }
    // relacion de equipo
    public function ordenEquipo() {
        return $this->belongsTo('App\OrdenEquipo');
    }
}
