<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class WhatsappOrder extends Model
{
    protected $table = 'whatsapp_orders';

    protected $fillable = [
        'user_id', 'order_number', 'customer_id', 'sale_id', 'whatsapp_customer_id',
        'customer_name', 'customer_phone', 'customer_email', 'is_registered_customer',
        'order_type', 'delivery_address', 'delivery_lat', 'delivery_lng',
        'delivery_notes', 'delivery_area',
        'items', 'items_count',
        'subtotal', 'discount_amount', 'coupon_code', 'delivery_fee',
        'tax_amount', 'tax_rate', 'total',
        'payment_method', 'payment_status', 'payment_link', 'payment_id',
        'payment_meta', 'paid_at',
        'status', 'status_history',
        'source', 'whatsapp_message_id', 'conversation_id',
        'customer_notes', 'merchant_notes', 'cancellation_reason',
        'confirmed_at', 'prepared_at', 'ready_at', 'delivered_at',
        'completed_at', 'cancelled_at', 'expected_delivery_at',
    ];

    protected $casts = [
        'items' => 'array',
        'status_history' => 'array',
        'payment_meta' => 'array',
        'is_registered_customer' => 'boolean',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'total' => 'decimal:2',
        'delivery_lat' => 'decimal:7',
        'delivery_lng' => 'decimal:7',
        'paid_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'prepared_at' => 'datetime',
        'ready_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'expected_delivery_at' => 'datetime',
    ];

    // ─── Auto-generate order number ───────────────────────────

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'WS-' . strtoupper(Str::random(8));
            }
        });
    }

    // ─── Relationships ─────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function whatsappCustomer(): BelongsTo
    {
        return $this->belongsTo(WhatsappCustomer::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(WhatsappMessage::class, 'whatsapp_order_id');
    }

    // ─── Status Management ─────────────────────────────────────

    public function updateStatus(string $newStatus, ?string $note = null): bool
    {
        $oldStatus = $this->status;
        $history = $this->status_history ?? [];
        
        $history[] = [
            'from' => $oldStatus,
            'to' => $newStatus,
            'note' => $note,
            'at' => now()->toIso8601String(),
        ];

        $this->status = $newStatus;
        $this->status_history = $history;

        $timestampField = match($newStatus) {
            'confirmed' => 'confirmed_at',
            'preparing' => 'prepared_at',
            'ready' => 'ready_at',
            'delivered' => 'delivered_at',
            'completed' => 'completed_at',
            'cancelled' => 'cancelled_at',
            default => null,
        };

        if ($timestampField && !$this->$timestampField) {
            $this->$timestampField = now();
        }

        return $this->save();
    }

    public function isConvertedToSale(): bool
    {
        return !empty($this->sale_id);
    }

    public function markAsPaid(string $paymentId, array $meta = []): bool
    {
        $this->payment_status = 'paid';
        $this->payment_id = $paymentId;
        $this->payment_meta = array_merge($this->payment_meta ?? [], $meta);
        $this->paid_at = now();
        return $this->save();
    }

    // ─── Scopes ────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['completed', 'cancelled', 'refunded']);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }
}
