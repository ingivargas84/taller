<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $table = 'cheques';

    protected $fillable = [
        'fecha',
        'cantidad',
        'no_cheque',
        'descripcion',
        'receptor',
        'referencia',
        'usuario_id',
        'persona_acepta',
        'cuenta_bancaria_id',
        'estado_cheque_id'
    ];

    public function estadoCheque() {
        return $this->belongsTo('App\EstadoCheque');
    }

    public function cuentaBancaria() {
        return $this->belongsTo('App\CuentaBancaria');
    }

    public function usuario() {
        return $this->belongsTo('App\User', 'usuario_id');
    }

    public function voucher() {
        return $this->hasOne('App\Voucher', 'cheque_id');
    }
}
