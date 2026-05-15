<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallmentPayment extends Model
{
    use HasFactory;

    /**
     * الجدول المرتبط بالـModel
     */
    protected $table = 'installment_payments';

    /**
     * الحقول القابلة للتعبئة
     */
    protected $fillable = [
        'installment_plan_id',
        'payment_number',
        'amount',
        'due_date',
        'paid_date',
        'status',
        'payment_method',
        'notes',
    ];

    /**
     * تحويل التواريخ
     */
    protected $casts = [
        'due_date'  => 'date',
        'paid_date' => 'date',
        'amount'    => 'decimal:2',
    ];

    // ═══════════════════════════════════════════════════
    // Constants
    // ═══════════════════════════════════════════════════

    const STATUS_PENDING   = 'pending';
    const STATUS_PAID      = 'paid';
    const STATUS_OVERDUE   = 'overdue';
    const STATUS_CANCELLED = 'cancelled';

    // ═══════════════════════════════════════════════════
    // Relationships
    // ═══════════════════════════════════════════════════

    /**
     * خطة التقسيط
     */
    public function installmentPlan()
    {
        return $this->belongsTo(InstallmentPlan::class, 'installment_plan_id');
    }

    // ═══════════════════════════════════════════════════
    // Scopes
    // ═══════════════════════════════════════════════════

    /**
     * الدفعات المدفوعة
     */
    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    /**
     * الدفعات المعلّقة
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * الدفعات المتأخرة
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', self::STATUS_OVERDUE)
                     ->orWhere(function ($q) {
                         $q->where('status', self::STATUS_PENDING)
                           ->where('due_date', '<', now());
                     });
    }

    // ═══════════════════════════════════════════════════
    // Accessors & Helpers
    // ═══════════════════════════════════════════════════

    /**
     * حالة الدفعة (نصية)
     */
    public function getStatusNameAttribute()
    {
        $statuses = [
            self::STATUS_PENDING   => 'معلّقة',
            self::STATUS_PAID      => 'مدفوعة',
            self::STATUS_OVERDUE   => 'متأخرة',
            self::STATUS_CANCELLED => 'ملغاة',
        ];

        // تحديث الحالة تلقائياً إذا تأخرت
        if ($this->status === self::STATUS_PENDING && $this->due_date < now()) {
            return $statuses[self::STATUS_OVERDUE];
        }

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * لون الحالة
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_PENDING   => 'warning',
            self::STATUS_PAID      => 'success',
            self::STATUS_OVERDUE   => 'danger',
            self::STATUS_CANCELLED => 'secondary',
        ];

        // تحديث اللون تلقائياً إذا تأخرت
        if ($this->status === self::STATUS_PENDING && $this->due_date < now()) {
            return $colors[self::STATUS_OVERDUE];
        }

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * هل الدفعة متأخرة؟
     */
    public function getIsOverdueAttribute()
    {
        return $this->status === self::STATUS_PENDING && $this->due_date < now();
    }

    /**
     * عدد الأيام المتبقية
     */
    public function getDaysRemainingAttribute()
    {
        if ($this->status === self::STATUS_PAID) {
            return 0;
        }

        return now()->diffInDays($this->due_date, false);
    }

    /**
     * نص عدد الأيام
     */
    public function getDaysRemainingTextAttribute()
    {
        $days = $this->days_remaining;

        if ($days > 0) {
            return "باقي {$days} يوم";
        } elseif ($days < 0) {
            return "متأخر " . abs($days) . " يوم";
        } else {
            return "اليوم";
        }
    }

    // ═══════════════════════════════════════════════════
    // Methods
    // ═══════════════════════════════════════════════════

    /**
     * تسجيل الدفعة كمدفوعة
     */
    public function markAsPaid($paymentMethod = null, $paidDate = null)
    {
        $this->update([
            'status'         => self::STATUS_PAID,
            'paid_date'      => $paidDate ?? now(),
            'payment_method' => $paymentMethod,
        ]);
    }

    /**
     * إلغاء الدفعة
     */
    public function cancel($notes = null)
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'notes'  => $notes,
        ]);
    }
}