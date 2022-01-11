<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenEquipo extends Model
{
    protected $table = 'ordenequipo';

    protected $fillable = [
    
        'id',
        'fecha_orden',
        'no_orden_trabajo',
        'no_comprobante',
        'has_guarantee',
        'cliente_id',
        'equipo_id',
        'tipo_trabajo_id',
        'ubicacion_id',
        'estado_id',
        'estado_orden_trabajo_id',
        'total_cobrar',
        'user_id',
        'observaciones', 
        'fecha_envia_ataller_p12', 
        'user_envia_ataller_p12', 
        'fecha_recibe_taller_p23', 
        'user_recibe_taller_p23',
        'fecha_envia_asesor_p34', 
        'user_envia_asesor_p34', 
        'fecha_recibe_asesor_p45', 
        'user_recibe_asesor_p45',
        'fecha_envia_llamada_p56', 
        'user_envia_llamada_p56', 
        'fecha_recibe_llamada_p67', 
        'user_recibe_llamada_p67',
        'fecha_envia_taller2_p78', 
        'user_envia_taller2_p78', 
        'fecha_recibe_taller2_p89', 
        'user_recibe_taller2_p89',
        'fecha_envia_recepcion3_p910', 
        'user_envia_recepcion3_p910', 
        'fecha_recibe_recepcion3_p1011', 
        'user_recibe_recepcion3_p1011'
        

    ];

    public function garantia() {
        return $this->hasMany('App\Garantia');
    }
    
    
    //Una orden de Equipo tiene una cuenta por Cobrar
    public function cuentaPorCobrar() {
        return $this->hasOne('App\CuentaPorCobrarDetalle', 'credito_id');
    }
        
    public function clientes()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function equipo()
    {
        return $this->belongsTo('App\Equipo');
    }

    public function tipo_trabajo()
    {
        return $this->belongsTo(TipoTrabajo::class);
    }

    public function empleados()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function ubicaciones()
    {
        return $this->belongsTo(UbicacionEquipo::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     //relacion de registro de envio de equipo
    public function registroEnvio() {
        return $this->hasMany('App\RegistroEnvioEquipo');
    }

    //relacion ruta vendedor
    public function rutasVendedor() {
        return $this->hasMany('App\RutaVendedor');
    }

    //Orden tiene factura
    public function facturas() {
        return $this->hasMany('App\Facturacion', 'orden_id');
    }

    //Diagnostico
    public function diagnostico() {
        return $this->hasMany('App\Diagnostico', 'ordenequipo_id');
    }
}
