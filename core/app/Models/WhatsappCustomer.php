<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WhatsappCustomer extends Model
{
    protected $table = 'whatsapp_customers';

    protected $fillable = [
        'user_id', 'customer_id',
        'phone', 'name', 'email',
        'whatsapp_profile_name', 'whatsapp_profile_picture', 'whatsapp_id',
        'preferred_language', 'preferred_payment_method',
        'delivery_addresses', 'favorite_products',
        'total_messages', 'total_orders', 'completed_orders', 'cancelled_orders',
        'total_spent', 'average_order_value',
        'first_message_at', 'last_message_at',
        'first_order_at', 'last_order_at', 'last_seen_at',
        'tags', 'segment', 'loyalty_points',
        'merchant_notes',
        'opt_in_marketing', 'opt_in_order_updates', 'is_blocked', 'block_reason',
        'acquisition_source',
    ];

    protected $casts = [
        'delivery_addresses' => 'array',
        'favorite_products' => 'array',
        'tags' => 'array',
        'opt_in_marketing' => 'boolean',
        'opt_in_order_updates' => 'boolean',
        'is_blocked' => 'boolean',
        'total_spent' => 'decimal:2',
        'average_order_value' => 'decimal:2',
        'first_message_at' => 'datetime',
        'last_message_at' => 'datetime',
        'first_order_at' => 'datetime',
        'last_order_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    // ─── Relationships ─────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(WhatsappOrder::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(WhatsappMessage::class);
    }

    // ─── Auto-Match with OvoSale Customer ─────────────────────

    public function matchWithOvoSaleCustomer(): ?Customer
    {
        if ($this->customer_id) {
            return $this->customer;
        }

        $normalized = preg_replace('/\D/', '', $this->phone);
        $lastNine = substr($normalized, -9);
        
        $customer = Customer::where('user_id', $this->user_id)
            ->where(function ($q) use ($lastNine) {
                $q->where('mobile', 'like', '%' . $lastNine)
                  ->orWhere('phone', 'like', '%' . $lastNine);
            })
            ->first();

        if ($customer) {
            $this->customer_id = $customer->id;
            $this->save();
            return $customer;
        }

        return null;
    }

    // ─── Stats Updates ─────────────────────────────────────────

    public function recordOrder(WhatsappOrder $order): void
    {
        $this->total_orders += 1;
        if ($order->status === 'completed') {
            $this->completed_orders += 1;
        }
        $this->total_spent += $order->total;
        $this->average_order_value = $this->total_orders > 0 
            ? round($this->total_spent / $this->total_orders, 2) 
            : 0;
        
        if (!$this->first_order_at) {
            $this->first_order_at = now();
        }
        $this->last_order_at = now();

        $this->updateSegment();
        $this->save();
    }

    public function updateSegment(): void
    {
        if ($this->total_orders === 0) {
            $this->segment = 'new';
        } elseif ($this->total_orders >= 10) {
            $this->segment = 'vip';
        } elseif ($this->last_order_at && $this->last_order_at->diffInDays(now()) > 90) {
            $this->segment = 'churned';
        } elseif ($this->last_order_at && $this->last_order_at->diffInDays(now()) > 30) {
            $this->segment = 'inactive';
        } else {
            $this->segment = 'regular';
        }
    }

    // ─── Scopes ────────────────────────────────────────────────

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeBySegment($query, string $segment)
    {
        return $query->where('segment', $segment);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('segment', ['regular', 'vip']);
    }

    public function scopeNotBlocked($query)
    {
        return $query->where('is_blocked', false);
    }
}
