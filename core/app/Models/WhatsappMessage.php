<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMessage extends Model
{
    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'user_id', 'whatsapp_customer_id', 'conversation_id',
        'direction', 'message_type',
        'meta_message_id', 'meta_phone_number_id', 'status',
        'content', 'media_url', 'media_mime_type', 'media_filename',
        'media_id', 'media_size_bytes',
        'location_lat', 'location_lng', 'location_name', 'location_address',
        'interactive_type', 'interactive_payload',
        'order_data', 'whatsapp_order_id',
        'template_name', 'template_language', 'template_components',
        'replied_to_meta_id', 'replied_to_message_id',
        'is_from_bot', 'is_handled', 'handler_type', 'handler_user_id', 'intent',
        'error_code', 'error_message', 'error_data', 'retry_count',
        'sent_at', 'delivered_at', 'read_at', 'failed_at',
        'cost_usd', 'conversation_category',
    ];

    protected $casts = [
        'interactive_payload' => 'array',
        'order_data' => 'array',
        'template_components' => 'array',
        'error_data' => 'array',
        'is_from_bot' => 'boolean',
        'is_handled' => 'boolean',
        'location_lat' => 'decimal:7',
        'location_lng' => 'decimal:7',
        'cost_usd' => 'decimal:4',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    // ─── Relationships ─────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function whatsappCustomer(): BelongsTo
    {
        return $this->belongsTo(WhatsappCustomer::class);
    }

    public function whatsappOrder(): BelongsTo
    {
        return $this->belongsTo(WhatsappOrder::class);
    }

    public function repliedToMessage(): BelongsTo
    {
        return $this->belongsTo(WhatsappMessage::class, 'replied_to_message_id');
    }

    // ─── Helpers ───────────────────────────────────────────────

    public function isInbound(): bool
    {
        return $this->direction === 'inbound';
    }

    public function isOutbound(): bool
    {
        return $this->direction === 'outbound';
    }

    public function isOrder(): bool
    {
        return $this->message_type === 'order';
    }

    public function markAsHandled(string $handlerType = 'bot', ?int $userId = null): bool
    {
        $this->is_handled = true;
        $this->handler_type = $handlerType;
        $this->handler_user_id = $userId;
        return $this->save();
    }

    public function markAsRead(): bool
    {
        $this->status = 'read';
        $this->read_at = now();
        return $this->save();
    }

    public function markAsDelivered(): bool
    {
        $this->status = 'delivered';
        $this->delivered_at = now();
        return $this->save();
    }

    public function markAsFailed(int $code, string $message): bool
    {
        $this->status = 'failed';
        $this->error_code = $code;
        $this->error_message = $message;
        $this->failed_at = now();
        return $this->save();
    }

    // ─── Scopes ────────────────────────────────────────────────

    public function scopeInbound($query)
    {
        return $query->where('direction', 'inbound');
    }

    public function scopeOutbound($query)
    {
        return $query->where('direction', 'outbound');
    }

    public function scopeUnhandled($query)
    {
        return $query->where('is_handled', false)->where('direction', 'inbound');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('message_type', $type);
    }

    public function scopeForCustomer($query, int $customerId)
    {
        return $query->where('whatsapp_customer_id', $customerId);
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }
}
