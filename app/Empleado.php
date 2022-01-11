<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $dates = ['fecha_nacimiento', 'fecha_alta', 'fecha_baja'];

    protected $fillable = [
        'nombres',
        'apellidos',
        'nit',
        'salario',
        'emp_cui',
        'direccion',
        'telefono',
        'celular',
        'email',
        'fecha_alta',
        'fecha_baja',
        'fecha_nacimiento',
        'puesto_id',
        'estado_id',
        'user_id',
        'user_asignado'
    ];

    public function puesto()
    {
        return $this->belongsTo(Puesto::class); //$empleado->puesto->nombre
    }

    public function estado()
    {
        return $this->belongsTo(EstadoEmpleado::class);
    }

    public function setFechaNacimientoAttribute($fecha_nacimiento)
    {
        $this->attributes['fecha_nacimiento'] = $fecha_nacimiento ? Carbon::parse($fecha_nacimiento) :null;
    }

    public function setFechaAltaAttribute($fecha_alta)
    {
        $this->attributes['fecha_alta'] = $fecha_alta ? Carbon::parse($fecha_alta) :null;
    }

    public function setFechaBajaAttribute($fecha_baja)
    {
        $this->attributes['fecha_baja'] = $fecha_baja ? Carbon::parse($fecha_baja) :null;
    }

    
    //relacion de registro de envio de equipo
    public function registroEnvio() {
        return $this->hasMany('App\RegistroEnvioEquipo');
    }

    //
    public function planillasMaestro() {
        return $this->hasMany('App\PlanillaMaestro', 'contador_id');
    }

    public function planillasMedio() {
        return $this->hasMany('App\PlanillaMedio', 'empleado_id');
    }
}
