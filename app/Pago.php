<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
      'id',
      'documento',
      'cantidad',
      'estado',
      'tipo_pago',
      'ordenequipo_id',
    ];

    public function tipo() {
      return $this->belongsTo('App\FormaPago', 'tipo_pago');
    }
}
