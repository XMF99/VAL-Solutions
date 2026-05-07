<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'id'                 => 'integer',
        'purchase_id'        => 'integer',
        'product_id'         => 'integer',
        'product_details_id' => 'integer',
        'base_price'         => 'double',
        'tax_id'             => 'integer',
        'tax_type'           => 'integer',
        'tax_amount'         => 'double',
        'tax_percentage'     => 'double',
        'purchase_price'     => 'double',
        'profit_margin'      => 'double',
        'sale_price'         => 'double',
        'discount_type'      => 'integer',
        'discount_value'     => 'double',
        'discount_amount'    => 'double',
        'final_price'        => 'double',
        'quantity'           => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class, 'product_details_id');
    }
}
