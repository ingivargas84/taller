<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = [
        'no_voucher',
        'receptor',
        'cheque_id'
    ];

    public function cheque() {
        return $this->belongsTo('App\Cheque', 'cheque_id');
    }
}
