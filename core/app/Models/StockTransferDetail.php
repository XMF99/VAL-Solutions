<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransferDetail extends Model
{
    protected $guarded  = ['id'];

    protected $casts = [
        'id'                 => 'integer',
        'stock_transfer_id'  => 'integer',
        'product_id'         => 'integer',
        'product_details_id' => 'integer',
        'quantity'           => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_details_id');
    }

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class, 'product_details_id');
    }
}
