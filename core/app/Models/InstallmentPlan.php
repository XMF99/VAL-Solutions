<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallmentPlan extends Model
{
    use HasFactory;

    /**
     * الجدول المرتبط بالـModel
     */
    protected $table = 'installments';

    /**
     * الحقول القابلة للتعبئة
     */
    protected $fillable = [
        'user_id',
        'sale_id',
        'total_amount',
        'number_of_installments',
        'installment_amount',
        'start_date',
        'frequency',
        'notes',
        'status',
    ];

    /**
     * تحويل التواريخ
     */
    protected $casts = [
        'start_date'   => 'date',
        'total_amount' => 'decimal:2',
        'installment_amount' => 'decimal:2',
    ];

    // ═══════════════════════════════════════════════════
    // Relationships
    // ═══════════════════════════════════════════════════

    /**
     * الفاتورة المرتبطة
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    /**
     * المستخدم صاحب الخطة
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * الدفعات الفردية
     */
    public function payments()
    {
        return $this->hasMany(InstallmentPayment::class, 'installment_plan_id');
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
     * الخطط النشطة
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // ═══════════════════════════════════════════════════
    // Accessors & Helpers
    // ═══════════════════════════════════════════════════

    /**
     * المبلغ المدفوع حتى الآن
     */
    public function getPaidAmountAttribute()
    {
        return $this->payments()->where('status', 'paid')->sum('amount');
    }

    /**
     * المبلغ المتبقي
     */
    public function getRemainingAmountAttribute()
    {
        return $this->total_amount - $this->paid_amount;
    }

    /**
     * عدد الدفعات المدفوعة
     */
    public function getPaidPaymentsCountAttribute()
    {
        return $this->payments()->where('status', 'paid')->count();
    }

    /**
     * نسبة الإتمام
     */
    public function getCompletionPercentageAttribute()
    {
        if ($this->total_amount == 0) {
            return 0;
        }
        return round(($this->paid_amount / $this->total_amount) * 100, 2);
    }

    /**
     * حالة الخطة (نصية)
     */
    public function getStatusNameAttribute()
    {
        if ($this->completion_percentage == 100) {
            return 'مكتملة';
        } elseif ($this->paid_payments_count > 0) {
            return 'قيد السداد';
        } else {
            return 'جديدة';
        }
    }

    /**
     * لون الحالة
     */
    public function getStatusColorAttribute()
    {
        if ($this->completion_percentage == 100) {
            return 'success';
        } elseif ($this->paid_payments_count > 0) {
            return 'info';
        } else {
            return 'secondary';
        }
    }

    /**
     * التكرار (نصي)
     */
    public function getFrequencyNameAttribute()
    {
        $frequencies = [
            'daily'   => 'يومي',
            'weekly'  => 'أسبوعي',
            'monthly' => 'شهري',
            'yearly'  => 'سنوي',
        ];

        return $frequencies[$this->frequency] ?? $this->frequency;
    }
}