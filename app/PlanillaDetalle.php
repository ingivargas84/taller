<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanillaDetalle extends Model
{
    protected $fillable = [
        'id',
        'planilla_medio_id',
        'movimiento_id',
        'subtotal'
    ];  

    public function planillaMedio() {
        return $this->belongsTo('App\PlanillaMedio', 'planilla_medio_id');
    }
    
    public function movimiento() {
        return $this->belongsTo('App\IngresoEgreso', 'movimiento_id');
    }

}
