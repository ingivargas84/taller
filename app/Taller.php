<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    protected $table = 'taller';

    protected $fillable = [
    
        'id',
        'ordenequipo_id',
        'dias_reparacion',
        'fecha_diagnostico',
        'detalle_diagnostico',
        'user_diagnostico_id',
        'fecha_autoriza_rechaza',
        'autoriza_rechaza',
        'detalle_llamada',
        'user_llamada_id',
        'fecha_reparacion',
        'trabajos_realizados',
        'user_reparacion_id',
        'estado_taller_id',
        'fecha_salida_taller',
        'observaciones',
        'user_salida_id'
    ];

    public function ordenequipo()
    {
        return $this->belongsTo(OrdenEquipo::class);
    }

    public function estado_taller()
    {
        return $this->belongsTo(EstadosTaller::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}

