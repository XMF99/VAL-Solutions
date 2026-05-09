<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappPublishedProduct extends Model
{
    protected $table = 'whatsapp_published_products';

    protected $fillable = [
        'user_id', 'product_id', 'whatsapp_setting_id',
        'meta_product_retailer_id', 'meta_product_id', 'meta_catalog_id',
        'is_published', 'is_featured', 'display_order',
        'whatsapp_name', 'whatsapp_description',
        'whatsapp_price', 'whatsapp_sale_price',
        'whatsapp_image_url', 'additional_images',
        'meta_category', 'whatsapp_brand', 'whatsapp_url',
        'availability', 'min_qty', 'max_qty',
        'requires_options', 'options_data',
        'sync_status', 'sync_error', 'sync_retries',
        'last_synced_at', 'next_sync_at',
        'view_count', 'add_to_cart_count', 'order_count',
        'total_revenue', 'last_ordered_at',
        'merchant_notes',
    ];

    protected $casts = [
        'additional_images' => 'array',
        'options_data' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'requires_options' => 'boolean',
        'whatsapp_price' => 'decimal:2',
        'whatsapp_sale_price' => 'decimal:2',
        'total_revenue' => 'decimal:2',
        'last_synced_at' => 'datetime',
        'next_sync_at' => 'datetime',
        'last_ordered_at' => 'datetime',
    ];

    // ─── Auto-generate retailer ID ────────────────────────────

    protected static function booted()
    {
        static::creating(function ($pp) {
            if (empty($pp->meta_product_retailer_id)) {
                $pp->meta_product_retailer_id = 'ovo_' . $pp->user_id . '_prod_' . $pp->product_id;
            }
        });
    }

    // ─── Relationships ─────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function whatsappSetting(): BelongsTo
    {
        return $this->belongsTo(WhatsappStoreSetting::class, 'whatsapp_setting_id');
    }

    // ─── Effective Values ──────────────────────────────────────

    public function getEffectiveNameAttribute(): string
    {
        return $this->whatsapp_name ?? $this->product?->name ?? 'منتج';
    }

    public function getEffectiveDescriptionAttribute(): ?string
    {
        return $this->whatsapp_description ?? $this->product?->description;
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->whatsapp_price ?? $this->product?->price ?? 0);
    }

    public function getEffectiveImageAttribute(): ?string
    {
        return $this->whatsapp_image_url ?? $this->product?->image;
    }

    // ─── Sync Status Helpers ──────────────────────────────────

    public function markAsSynced(string $metaProductId): bool
    {
        $this->meta_product_id = $metaProductId;
        $this->sync_status = 'synced';
        $this->sync_error = null;
        $this->sync_retries = 0;
        $this->last_synced_at = now();
        return $this->save();
    }

    public function markSyncFailed(string $error): bool
    {
        $this->sync_status = 'failed';
        $this->sync_error = $error;
        $this->sync_retries += 1;
        $this->next_sync_at = now()->addMinutes(min(60, $this->sync_retries * 5));
        return $this->save();
    }

    public function needsSync(): bool
    {
        return in_array($this->sync_status, ['pending', 'failed']);
    }

    // ─── Analytics Updates ────────────────────────────────────

    public function incrementViews(): void
    {
        $this->increment('view_count');
    }

    public function recordOrder(float $revenue, int $qty = 1): void
    {
        $this->order_count += $qty;
        $this->total_revenue += $revenue;
        $this->last_ordered_at = now();
        $this->save();
    }

    // ─── Scopes ────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeNeedsSync($query)
    {
        return $query->whereIn('sync_status', ['pending', 'failed']);
    }

    public function scopeAvailable($query)
    {
        return $query->where('availability', 'in_stock');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('id');
    }
}
