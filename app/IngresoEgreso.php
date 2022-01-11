<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoEgreso extends Model
{
    protected $fillable = [
        'id',
        'nombre',
        'porcentaje',
        'cantidad_multiplicar',
        'cantidad_ingreso_fijo',
        'estado',
        'tipo_movimiento_id',
        'tipo_calculo_id',
        'campo_pc_id',
        'campo_am_id',
    ];

    //Un IE es un tipo de movimiento
    public function tipoMov() {
        return $this->belongsTo('App\MovIngresoEgreso', 'tipo_movimiento_id');
    }
    //Un IE es un tipo de calculo
    public function tipoCalculo() {
        return $this->belongsTo('App\TipoCalculo');
    }
    //Un IE tiene valores Porcentaje calculado
    public function valorPC() {
         return $this->belongsTo('App\ValoresPorCalculado', 'campo_pc_id');
    }

    //Un IE tiene valores Fijo
    public function valorFijo() {
         return $this->belongsTo('App\ValoresFijo', 'campo_am_id');
    }

    //Estado
    public function estado() {
        return $this->belongsTo('App\estado');
    }

    //Planillas detalle
    public function planillasDetalle() {
        return $this->hasMany('App\PlanillaDetalle', 'movimiento_id');
    }
    
}
