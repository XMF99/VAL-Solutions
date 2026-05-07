<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use GlobalStatus, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'user_id'            => 'integer',
        'start_from'         => 'date',
        'end_at'             => 'date',

        'minimum_amount'     => 'double',
        'amount'             => 'double',

        'discount_type'      => 'integer',
        'maximum_using_time' => 'integer',

        'status'             => 'integer',
        'deleted_at'         => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
