<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoCheque extends Model
{
    protected $table = 'estado_cheques';

    protected $fillable = ['estado'];

    public function cheques() {
        return $this->hasMany('App\Cheque', 'estado_cheque_id');
    }
}
