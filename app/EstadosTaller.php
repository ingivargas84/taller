<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\estados;

class EstadosTaller extends Model
{
    protected $table = 'estados_taller';

    protected $fillable = [
        'nombre',
        'estado_id'
    ];

    public function estado() {
        return $this->belongsTo('App\estados');
    }
}
