<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
    
        'id',
        'tipocliente_id',
        'nit',
        'nombre_fiscal',
        'nombre_comercial',
        'telefono',
        'correo_electronico',
        'direccion',
        'ubicacion',
        'fecha_imp',
        'nombre_contacto1',
        'puesto_contacto1',
        'telefono_contacto1',
        'correo_contacto1',
        'nombre_contacto2',
        'puesto_contacto2',
        'telefono_contacto2',
        'correo_contacto2',
        'empleado_id',
        'estado_id', 
        'user_id'
    ];          
    
    public function garantia() {
        return $this->hasMany('App\Garantia');
    }
    
    public function tipo_cliente()
    {
        return $this->belongsTo(tipo_cliente::class);
    }

    public function empleado()
    {
        return $this->belongsTo(empleado::class);
    }

    public function estado()
    {
        return $this->belongsTo(estados::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); //$puesto->user->name
    }

    public function cotizaciones() 
    {
        return $this->hasMany('App\CotizacionMaestro');
    }
    
    //rutas
    public function rutas() {
        return $this->hasMany('App\RutasVendedor', 'cliente_id');
    }

    //Cliente tiene varios facturas
    public function facturas() {
        return $this->hasMany('App\Facturacion');
    }
    
}
