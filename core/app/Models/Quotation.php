<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    use HasFactory;

    /**
     * ─── حالات عروض الأسعار ───
     */
    const STATUS_DRAFT     = 0;  // مسودّة
    const STATUS_SENT      = 1;  // أُرسلت للعميل
    const STATUS_ACCEPTED  = 2;  // مقبولة
    const STATUS_REJECTED  = 3;  // مرفوضة
    const STATUS_EXPIRED   = 4;  // منتهية الصلاحية

    /**
     * ─── الحقول المسموح ملؤها ───
     */
    protected $fillable = [
        'user_id',
        'quotation_no',
        'customer_id',
        'quotation_date',
        'valid_until',
        'subtotal',
        'tax',
        'discount',
        'total',
        'quotation_status',
        'notes',
        'status',
    ];

    /**
     * ─── تحويل الأنواع تلقائياً ───
     */
    protected $casts = [
        'quotation_date' => 'date',
        'valid_until'    => 'date',
        'subtotal'       => 'decimal:2',
        'tax'            => 'decimal:2',
        'discount'       => 'decimal:2',
        'total'          => 'decimal:2',
    ];

    // ═══════════════════════════════════════════════════
    // العلاقات
    // ═══════════════════════════════════════════════════

    /**
     * عرض السعر تابع لمستخدم
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * عرض السعر تابع لعميل
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * عرض السعر له عدّة بنود (منتجات)
     */
    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    // ═══════════════════════════════════════════════════
    // الـScopes (استعلامات جاهزة)
    // ═══════════════════════════════════════════════════

    /**
     * عروض المستخدم الحالي فقط
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * المسودّات فقط
     */
    public function scopeDraft($query)
    {
        return $query->where('quotation_status', self::STATUS_DRAFT);
    }

    /**
     * المرسلة فقط
     */
    public function scopeSent($query)
    {
        return $query->where('quotation_status', self::STATUS_SENT);
    }

    /**
     * المقبولة فقط
     */
    public function scopeAccepted($query)
    {
        return $query->where('quotation_status', self::STATUS_ACCEPTED);
    }

    /**
     * المنتهية (تاريخ الصلاحيّة فات)
     */
    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<', now())
                     ->whereNotIn('quotation_status', [self::STATUS_ACCEPTED, self::STATUS_REJECTED]);
    }

    // ═══════════════════════════════════════════════════
    // مساعدات
    // ═══════════════════════════════════════════════════

    /**
     * احصل على اسم الحالة بالعربي
     */
    public function getStatusNameAttribute(): string
    {
        return match ($this->quotation_status) {
            self::STATUS_DRAFT    => 'مسودّة',
            self::STATUS_SENT     => 'أُرسلت',
            self::STATUS_ACCEPTED => 'مقبولة',
            self::STATUS_REJECTED => 'مرفوضة',
            self::STATUS_EXPIRED  => 'منتهية',
            default               => 'غير معروف',
        };
    }

    /**
     * احصل على لون الحالة (لـbadge)
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->quotation_status) {
            self::STATUS_DRAFT    => 'secondary',
            self::STATUS_SENT     => 'info',
            self::STATUS_ACCEPTED => 'success',
            self::STATUS_REJECTED => 'danger',
            self::STATUS_EXPIRED  => 'warning',
            default               => 'secondary',
        };
    }

    /**
     * هل عرض السعر منتهي الصلاحيّة؟
     */
    public function isExpired(): bool
    {
        return $this->valid_until && $this->valid_until->isPast()
            && !in_array($this->quotation_status, [self::STATUS_ACCEPTED, self::STATUS_REJECTED]);
    }

    /**
     * توليد رقم عرض سعر تلقائي
     */
    public static function generateQuotationNo(int $userId): string
    {
        $year   = date('Y');
        $count  = static::where('user_id', $userId)->whereYear('created_at', $year)->count() + 1;
        $padded = str_pad($count, 4, '0', STR_PAD_LEFT);
        return "QT-{$year}-{$padded}";
    }
}
