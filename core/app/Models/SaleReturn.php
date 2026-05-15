<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;

    /**
     * الجدول المرتبط بالـModel
     */
    protected $table = 'sale_returns';

    /**
     * الحقول القابلة للتعبئة
     */
    protected $fillable = [
        'user_id',
        'sale_id',
        'return_no',
        'return_date',
        'subtotal',
        'tax',
        'discount',
        'total',
        'refund_method',
        'return_reason',
        'notes',
        'status',
    ];

    /**
     * تحويل التواريخ
     */
    protected $casts = [
        'return_date' => 'date',
        'subtotal'    => 'decimal:2',
        'tax'         => 'decimal:2',
        'discount'    => 'decimal:2',
        'total'       => 'decimal:2',
    ];

    // ═══════════════════════════════════════════════════
    // Constants
    // ═══════════════════════════════════════════════════

    const STATUS_PENDING   = 0;
    const STATUS_APPROVED  = 1;
    const STATUS_REJECTED  = 2;
    const STATUS_COMPLETED = 3;

    const REFUND_CASH    = 'cash';
    const REFUND_CREDIT  = 'credit';
    const REFUND_EXCHANGE = 'exchange';

    // ═══════════════════════════════════════════════════
    // Relationships
    // ═══════════════════════════════════════════════════

    /**
     * الفاتورة الأصلية
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    /**
     * المستخدم صاحب المرتجع
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * بنود المرتجع
     */
    public function items()
    {
        return $this->hasMany(SaleReturnItem::class, 'sale_return_id');
    }

    // ═══════════════════════════════════════════════════
    // Scopes
    // ═══════════════════════════════════════════════════

    /**
     * فلترة حسب المستخدم
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * المرتجعات المعلّقة
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * المرتجعات المعتمدة
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * المرتجعات المكتملة
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    // ═══════════════════════════════════════════════════
    // Accessors & Helpers
    // ═══════════════════════════════════════════════════

    /**
     * حالة المرتجع (نصية)
     */
    public function getStatusNameAttribute()
    {
        $statuses = [
            self::STATUS_PENDING   => 'معلّق',
            self::STATUS_APPROVED  => 'معتمد',
            self::STATUS_REJECTED  => 'مرفوض',
            self::STATUS_COMPLETED => 'مكتمل',
        ];

        return $statuses[$this->status] ?? 'غير معروف';
    }

    /**
     * لون الحالة
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_PENDING   => 'warning',
            self::STATUS_APPROVED  => 'info',
            self::STATUS_REJECTED  => 'danger',
            self::STATUS_COMPLETED => 'success',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * طريقة الرد (نصية)
     */
    public function getRefundMethodNameAttribute()
    {
        $methods = [
            self::REFUND_CASH     => 'نقدي',
            self::REFUND_CREDIT   => 'رصيد',
            self::REFUND_EXCHANGE => 'استبدال',
        ];

        return $methods[$this->refund_method] ?? $this->refund_method;
    }

    /**
     * توليد رقم مرتجع جديد
     */
    public static function generateReturnNo($userId)
    {
        $year   = date('Y');
        $prefix = "SR-{$year}-";

        $lastReturn = self::where('user_id', $userId)
            ->where('return_no', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastReturn) {
            $lastNumber = (int) substr($lastReturn->return_no, strlen($prefix));
            $newNumber  = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}