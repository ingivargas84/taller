<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoPlanilla extends Model
{
    protected $fillable = [
        'estado'
    ];

    //Estado tiene muchas planillas maestro
    public function planillasMaestro() {
        return $this->hasMany('App\PlanillaMaestro', 'estado_planilla_id');
    }
}
