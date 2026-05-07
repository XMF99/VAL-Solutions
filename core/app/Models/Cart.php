<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'warehouse_id'       => 'integer',
        'product_details_id' => 'integer',
        'quantity'           => 'integer',
        'user_id'            => 'integer',
    ];

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class, 'product_details_id');
    }
}
