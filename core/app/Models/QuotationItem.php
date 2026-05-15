<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationItem extends Model
{
    use HasFactory;

    /**
     * ─── اسم الجدول ───
     * (نحدّده صراحة لأن Laravel سيحوّل QuotationItem → quotation_items تلقائياً
     *  لكن نكتبه للوضوح)
     */
    protected $table = 'quotation_items';

    /**
     * ─── الحقول المسموح ملؤها ───
     */
    protected $fillable = [
        'quotation_id',
        'product_id',
        'product_name',
        'description',
        'quantity',
        'unit_price',
        'discount',
        'tax_rate',
        'subtotal',
        'total',
        'sort_order',
    ];

    /**
     * ─── تحويل الأنواع ───
     */
    protected $casts = [
        'quantity'   => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discount'   => 'decimal:2',
        'tax_rate'   => 'decimal:2',
        'subtotal'   => 'decimal:2',
        'total'      => 'decimal:2',
    ];

    // ═══════════════════════════════════════════════════
    // العلاقات
    // ═══════════════════════════════════════════════════

    /**
     * البند تابع لعرض سعر
     */
    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    /**
     * البند مرتبط بمنتج (اختياري — قد يكون يدوي)
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ═══════════════════════════════════════════════════
    // مساعدات الحسابات
    // ═══════════════════════════════════════════════════

    /**
     * احسب المجموع الفرعي للبند (قبل الضريبة والخصم)
     */
    public function calculateSubtotal(): float
    {
        return (float) ($this->quantity * $this->unit_price);
    }

    /**
     * احسب الخصم بالنسبة المئويّة
     */
    public function calculateDiscountAmount(): float
    {
        $subtotal = $this->calculateSubtotal();
        return (float) ($subtotal * ($this->discount / 100));
    }

    /**
     * احسب الضريبة
     */
    public function calculateTaxAmount(): float
    {
        $subtotal      = $this->calculateSubtotal();
        $afterDiscount = $subtotal - $this->calculateDiscountAmount();
        return (float) ($afterDiscount * ($this->tax_rate / 100));
    }

    /**
     * احسب الإجمالي النهائي للبند
     */
    public function calculateTotal(): float
    {
        $subtotal      = $this->calculateSubtotal();
        $afterDiscount = $subtotal - $this->calculateDiscountAmount();
        $afterTax      = $afterDiscount + $this->calculateTaxAmount();
        return (float) $afterTax;
    }

    /**
     * أعد حساب وحفظ كل القيم تلقائياً قبل الحفظ
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function (QuotationItem $item) {
            $item->subtotal = $item->calculateSubtotal();
            $item->total    = $item->calculateTotal();
        });
    }
}
