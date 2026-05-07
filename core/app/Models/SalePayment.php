<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalePayment extends Model
{
    protected $guarded  = ['id'];

    protected $casts = [
        'id'           => 'integer',
        'sale_id'      => 'integer',
        'customer_id'  => 'integer',
        'payment_type' => 'integer',
        'amount'       => 'double',
        'date'         => 'date'
    ];

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type');
    }
}
