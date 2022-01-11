<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'nit',
        'telefono',
        'email',
        'nombre_legal',
        'nombre_comercial',
        'direccion',
        'nombre_contacto1',
        'puesto_contacto1',
        'telefono_contacto1',
        'correo_contacto1',
        'nombre_contacto2',
        'puesto_contacto2',
        'telefono_contacto2',
        'correo_contacto2',
        'observaciones',
        'estado',
        'user_id',
    ];

    public function estadoCuentaProveedor() 
    {
        return $this->hasMany('App/EstadoCuentaProveedor');
    }

    public function cuentaPorPagarMaestro() {
        return $this->hasOne('App\CuentaPorPagarMaestro');
    }
}
