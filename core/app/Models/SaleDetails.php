<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetails extends Model
{
    protected $guarded  = ['id'];

    protected $casts = [
        'id'                 => 'integer',
        'sale_id'            => 'integer',
        'product_id'         => 'integer',
        'product_details_id' => 'integer',
        'tax_id'             => 'integer',
        'tax_type'           => 'integer',
        'tax_amount'         => 'double',
        'tax_percentage'     => 'double',
        'discount_type'      => 'integer',
        'discount_value'     => 'double',
        'discount_amount'    => 'double',
        'purchase_price'     => 'double',
        'unit_price'         => 'double',
        'sale_price'         => 'double',
        'quantity'           => 'integer',
        'subtotal'           => 'double'
    ];

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class, 'product_details_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
