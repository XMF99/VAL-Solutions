<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use GlobalStatus;

    protected $guarded = ['id'];

    protected $casts = [
        'id'              => 'integer',
        'product_limit'   => 'integer',
        'user_limit'      => 'integer',
        'warehouse_limit' => 'integer',
        'supplier_limit'  => 'integer',
        'coupon_limit'    => 'integer',
        'hrm_access'      => 'integer',
        'monthly_price'   => 'double',
        'yearly_price'    => 'double',
        'status'          => 'integer'
    ];
}
