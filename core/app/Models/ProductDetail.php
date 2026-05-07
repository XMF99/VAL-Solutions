<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'id'               => 'integer',
        'product_id'       => 'integer',
        'user_id'          => 'integer',
        'base_price'       => 'double',
        'tax_id'           => 'integer',
        'tax_type'         => 'integer',
        'tax_amount'       => 'double',
        'tax_percentage'   => 'double',
        'purchase_price'   => 'double',
        'profit_margin'    => 'double',
        'sale_price'       => 'double',
        'discount_type'    => 'integer',
        'discount_value'   => 'double',
        'discount_amount'  => 'double',
        'final_price'      => 'double',
        'alert_quantity'   => 'double',
        'variant_id'       => 'integer',
        'attribute_id'     => 'integer'
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function productStock()
    {
        return $this->hasMany(ProductStock::class, 'product_details_id');
    }

    public function salesDetails()
    {
        return $this->hasMany(SaleDetails::class, 'product_details_id');
    }
}
