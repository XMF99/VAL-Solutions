<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRegisterTransaction extends Model
{
    protected $casts = [
        'cash_register_id' => 'integer',
        'amount'           => 'double',
        'trx_type'         => 'integer',
        'payment_type_id'  => 'integer'
    ];
}
