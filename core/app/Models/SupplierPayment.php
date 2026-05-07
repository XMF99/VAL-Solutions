<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPayment extends Model
{
    protected $guarded  = ['id'];

    protected $casts = [
        'id'              => 'integer',
        'purchase_id'     => 'integer',
        'supplier_id'     => 'integer',
        'payment_type_id' => 'integer',
        'amount'          => 'double',
        'payment_date'    => 'date'
    ];

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }
}
