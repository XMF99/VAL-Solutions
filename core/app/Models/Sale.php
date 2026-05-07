<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    protected $guarded  = ['id'];

    protected $casts = [
        'id'              => 'integer',
        'user_id'         => 'integer',
        'sale_date'       => 'date',
        'customer_id'     => 'integer',
        'warehouse_id'    => 'integer',
        'discount_type'   => 'integer',
        'discount_value'  => 'double',
        'discount_amount' => 'double',
        'shipping_amount' => 'double',
        'subtotal'        => 'double',
        'total'           => 'double',
        'paying_amount'   => 'double',
        'changes_amount'  => 'double',
        'sale_by'         => 'integer',
        'is_pos_sale'     => 'integer',
        'status'          => 'integer',
        'coupon_id'       => 'integer'
    ];

    public function exportColumns(): array
    {
        return  [
            'invoice_number',
            'warehouse_id' => [
                'name' => 'warehouse',
                'callback' => function ($item) {
                    return @$item->warehouse->name;
                }
            ],
            'customer_id' => [
                'name' => 'customer',
                'callback' => function ($item) {
                    return @$item->customer->name;
                }
            ],
            'total' => [
                'callback' => function ($item) {
                    return showAmount($item->total);
                }
            ],
            'status' => [
                'callback' => function ($item) {
                    return strip_tags($item->statusBadge);
                }
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function saleBy()
    {
        return $this->belongsTo(User::class, 'sale_by');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function payments()
    {
        return $this->hasMany(SalePayment::class, 'sale_id');
    }
    public function saleDetails()
    {
        return $this->hasMany(SaleDetails::class, 'sale_id');
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: function () {
                $html = '';
                if ($this->status == Status::SALE_FINAL) {
                    $html = '<span class="badge badge--success">' . trans('Final') . '</span>';
                } elseif ($this->status == Status::SALE_QUOTATION) {
                    $html = '<span class="badge badge--warning">' . trans('quotation') . '</span>';
                }
                return $html;
            },
        );
    }
}
