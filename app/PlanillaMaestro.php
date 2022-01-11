<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanillaMaestro extends Model
{
    protected $fillable = [
        'no_planilla',
        'titulo',
        'anio',
        'contador_id',
        'total',
        'estado_planilla_id',
        'fecha_planilla'
    ];
    //
    public function contador() {
        return $this->belongsTo('App\User', 'contador_id');
    }

    //
    public function estado() {
        return $this->belongsTo('App\EstadoPlanilla', 'estado_planilla_id');
    }
    //
    public function planillasMedio() {
        return $this->hasMany('App\PlanillaMedio', 'planilla_maestro_id');
    }
}


