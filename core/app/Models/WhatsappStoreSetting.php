
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class WhatsappStoreSetting extends Model
{
    protected $table = 'whatsapp_store_settings';

    protected $fillable = [
        'company_id', 'store_slug', 'store_name', 'store_description',
        'logo_url', 'cover_url', 'theme_color',
        'whatsapp_number', 'whatsapp_display_name', 'whatsapp_phone_id',
        'whatsapp_business_id', 'access_token', 'catalog_id', 'webhook_verify_token',
        'welcome_message', 'away_message', 'order_confirmation_message',
        'business_hours', 'is_open_now',
        'min_order_amount', 'delivery_fee', 'delivery_areas',
        'accepts_cash', 'accepts_apple_pay', 'accepts_google_pay',
        'accepts_mada', 'accepts_visa', 'accepts_bank_transfer',
        'moyasar_publishable_key', 'moyasar_secret_key', 'moyasar_status',
        'is_active', 'is_verified', 'connected_at', 'last_message_at',
        'total_orders', 'total_revenue', 'total_customers',
    ];

    protected $casts = [
        'business_hours' => 'array',
        'delivery_areas' => 'array',
        'is_open_now' => 'boolean',
        'accepts_cash' => 'boolean',
        'accepts_apple_pay' => 'boolean',
        'accepts_google_pay' => 'boolean',
        'accepts_mada' => 'boolean',
        'accepts_visa' => 'boolean',
        'accepts_bank_transfer' => 'boolean',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'connected_at' => 'datetime',
        'last_message_at' => 'datetime',
        'min_order_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total_revenue' => 'decimal:2',
    ];

    protected $hidden = [
        'access_token',
        'moyasar_secret_key',
        'webhook_verify_token',
    ];

    // ─── Relationships ─────────────────────────────────────────

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function publishedProducts(): HasMany
    {
        return $this->hasMany(WhatsappPublishedProduct::class, 'whatsapp_setting_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(WhatsappOrder::class, 'company_id', 'company_id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(WhatsappCustomer::class, 'company_id', 'company_id');
    }

    // ─── Encryption Mutators ───────────────────────────────────

    public function setAccessTokenAttribute($value)
    {
        $this->attributes['access_token'] = $value ? encrypt($value) : null;
    }

    public function getAccessTokenAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    public function setMoyasarSecretKeyAttribute($value)
    {
        $this->attributes['moyasar_secret_key'] = $value ? encrypt($value) : null;
    }

    public function getMoyasarSecretKeyAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    // ─── Helper Methods ────────────────────────────────────────

    public function isConnected(): bool
    {
        return !empty($this->whatsapp_phone_id) && $this->is_active;
    }

    public function isCurrentlyOpen(): bool
    {
        if (!$this->is_open_now) return false;
        
        $hours = $this->business_hours;
        if (!$hours) return true;
        
        $day = strtolower(now()->format('D'));
        if (!isset($hours[$day])) return false;
        
        $now = now()->format('H:i');
        return $now >= ($hours[$day]['open'] ?? '00:00') 
            && $now <= ($hours[$day]['close'] ?? '23:59');
    }

    public function getEnabledPaymentMethods(): array
    {
        return collect([
            'cash' => $this->accepts_cash,
            'apple_pay' => $this->accepts_apple_pay,
            'google_pay' => $this->accepts_google_pay,
            'mada' => $this->accepts_mada,
            'visa' => $this->accepts_visa,
            'bank_transfer' => $this->accepts_bank_transfer,
        ])->filter()->keys()->toArray();
    }

    public function publicStoreUrl(): string
    {
        return url('/store/' . $this->store_slug);
    }

    // ─── Scopes ────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeConnected($query)
    {
        return $query->whereNotNull('whatsapp_phone_id')->where('is_active', true);
    }
}
