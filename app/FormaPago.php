<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\estados;

class FormaPago extends Model
{
    protected $table = 'forma_pagos';

    protected $fillable = ['nombre','estado_id'];

    public function estado() {
        return $this->belongsTo('App\estados');
    }
}
