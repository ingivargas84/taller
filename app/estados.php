<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Vendedor; 
use App\Producto; 
use App\FormaPago;
use App\TipoTrabajo;
use App\EstadosTaller;

class estados extends Model
{
    protected $table = 'estados';

    protected $fillable = [
        'id',
        'estado'
    ];

    public function garantia() {
        return $this->hasMany('App\Garantia');
    }

    public function vendedores() {
        return $this->hasMany('App\Vendedor' , 'estado_id');
    }

    public function clientes() {
        return $this->hasMany('App\Cliente', 'estado_id');
    }

    public function formaPagos() {
        return $this->hasMany('App\FormaPago', 'estado_id');
    }

    public function tipoTrabajos() {
        return $this->hasMany('App\TipoTrabajo', 'estado_id');
    }

    public function estadosTaller() {
        return $this->hasMany('App\EstadosTaller', 'estado_id');
    }

    public function ubicacionesEquipo() {
        return $this->hasMany('App\UbicacionEquipo', 'estado_id');
    }

    public function equipos() {
        return $this->hasMany('App\Equipo', 'estado_id');
    }

    public function productos() {
        return $this->hasMany('App\Producto', 'estado_id');
    }

     public function estadoCuentaProveedor() {
        return $this->hasMany('App/EstadoCuentaProveedor', 'estado_id');
    }

    public function ingresosMaestro() {
        return $this->hasMany('App\IngresoMaestro', 'estado_id');
    }

    public function servicios() {
        return $this->hasMany('App\Servicio', 'estado_id');
    }

    public function cotizaciones() {
        return $this->hasMany('App\CotizacionMaestro', 'estado_id');
    }

    public function cotizacionesDetalle() {
        return $this->hasMany('App\CotizacionDetalle', 'estado_id');
    }

    public function cajasDetalle() {
        return $this->hasMany('App\CajaDetalle', 'estado_id');
    }

    public function cuentaBancaria() {
        return $this->hasMany('App\CajaDetalle', 'estado_id');
    }

    //Muchas cuentas por pagar
    public function cuentasPorPagarMaestro() {
        return $this->hasMany('App\CuentaPorPagarMaestro');
    }

    //Muchos movimientos Ingreso|Egreso 
    public function ingresoEgresoMovs() {
        return $this->hasMany('App\IngresoEgreso');
    }
}
