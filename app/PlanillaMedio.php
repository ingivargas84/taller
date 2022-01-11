<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanillaMedio extends Model
{
    //
    protected $fillable = [
        'id',
        'planilla_maestro_id',
        'empleado_id',
        'total_ingresos',
        'total_egresos',
        'total_liquido'
    ];
    
    //
    public function planillaMaestro() {
        return $this->belongsTo('App\PlanillaMaestro');
    }

    public function colaborador() {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }    

    public function planillasDetalle() {
        return $this->hasMany('App\PlanillaDetalle', 'planilla_medio_id');
    }

}
