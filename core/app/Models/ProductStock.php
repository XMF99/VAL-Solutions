<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $guarded  = ['id'];

    protected $casts = [
        'id'                 => 'integer',
        'product_id'         => 'integer',
        'product_details_id' => 'integer',
        'warehouse_id'       => 'integer',
        'stock'              => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class, 'product_details_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function exportColumns(): array
    {
        return  [
            'product_details_id' => [
                'name' => 'product_sku',
                'callback' => function ($item) {
                    return @$item->productDetail->sku;
                }
            ],
            'warehouse_id' => [
                'name' => 'warehouse',
                'callback' => function ($item) {
                    return @$item->warehouse->name;
                }
            ],
            'stock' => [
                'callback' => function ($item) {
                    return @$item->stock . " " . @$item->product->unit->name;
                }
            ]
        ];
    }
}
