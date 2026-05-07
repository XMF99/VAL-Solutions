<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PlanPurchase extends Model
{
    use GlobalStatus;

    protected $casts = [
        'id'                      => 'integer',
        'user_id'                 => 'integer',
        'recurring_type'          => 'integer',
        'amount'                  => 'double',
        'payment_method'          => 'integer',
        'gateway_method_code'     => 'integer',
        'subscription_plan_id'    => 'integer',
        'auto_renewal'            => 'integer',
        'is_sent_expired_notify'  => 'integer',
        'is_sent_reminder_notify' => 'integer',
        'expired_at'              => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_method_code', 'code');
    }

    public function billingCycle(): Attribute
    {
        return new Attribute(
            get: fn() => $this->recurring_type == Status::MONTHLY ? 'Monthly' : 'Yearly',
        );
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::PLAN_ACTIVATE) {
                $html = '<span class="badge badge--success">' . trans('Activate') . '</span>';
            } elseif ($this->status == Status::PLAN_EXPIRED) {
                $html = '<span class="badge badge--danger">' . trans('Expired') . '</span>';
            } elseif ($this->status == Status::PLAN_PENDING) {
                $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
            } else {
                $html = '<span class="badge badge--info">' . trans('Trial') . '</span>';
            }
            return $html;
        });
    }
}
