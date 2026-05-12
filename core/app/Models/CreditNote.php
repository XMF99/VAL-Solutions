<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{
    protected $casts = [
        'subtotal'          => 'decimal:2',
        'discount_amount'   => 'decimal:2',
        'shipping_amount'   => 'decimal:2',
        'total'             => 'decimal:2',
        'applied_amount'    => 'decimal:2',
        'refunded_amount'   => 'decimal:2',
        'balance_amount'    => 'decimal:2',
        'affects_inventory' => 'boolean',
    ];

    // ═══════════════════════════════════════════════════════════
    // Status Constants
    // ═══════════════════════════════════════════════════════════
    
    const STATUS_CANCELLED      = 0;
    const STATUS_ACTIVE         = 1;
    const STATUS_FULLY_APPLIED  = 2;

    // ═══════════════════════════════════════════════════════════
    // Relationships
    // ═══════════════════════════════════════════════════════════

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function details()
    {
        return $this->hasMany(CreditNoteDetail::class);
    }

    // ═══════════════════════════════════════════════════════════
    // Scopes
    // ═══════════════════════════════════════════════════════════

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeFullyApplied($query)
    {
        return $query->where('status', self::STATUS_FULLY_APPLIED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    // ═══════════════════════════════════════════════════════════
    // Accessors
    // ═══════════════════════════════════════════════════════════

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_ACTIVE         => 'نشط',
            self::STATUS_CANCELLED      => 'ملغي',
            self::STATUS_FULLY_APPLIED  => 'مُطبّق بالكامل',
            default                     => 'غير محدّد',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            self::STATUS_ACTIVE         => 'badge--success',
            self::STATUS_CANCELLED      => 'badge--danger',
            self::STATUS_FULLY_APPLIED  => 'badge--secondary',
            default                     => 'badge--warning',
        };
    }

    public function getReasonLabelAttribute(): string
    {
        return match($this->reason) {
            'return'    => 'إرجاع منتج',
            'damage'    => 'منتج تالف',
            'discount'  => 'خصم متأخّر',
            'error'     => 'خطأ في الفاتورة',
            'other'     => 'أخرى',
            default     => '—',
        };
    }

    public function getIsFullyAppliedAttribute(): bool
    {
        return $this->status == self::STATUS_FULLY_APPLIED || $this->balance_amount <= 0;
    }
}
