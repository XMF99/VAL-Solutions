<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturnItem extends Model
{
    use HasFactory;

    /**
     * الجدول المرتبط بالـModel
     */
    protected $table = 'sale_return_items';

    /**
     * الحقول القابلة للتعبئة
     */
    protected $fillable = [
        'sale_return_id',
        'sale_item_id',
        'product_id',
        'product_name',
        'quantity',
        'unit_price',
        'discount',
        'tax_rate',
        'subtotal',
        'total',
        'return_reason',
    ];

    /**
     * تحويل الأنواع
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
    // Relationships
    // ═══════════════════════════════════════════════════

    /**
     * المرتجع الأساسي
     */
    public function saleReturn()
    {
        return $this->belongsTo(SaleReturn::class, 'sale_return_id');
    }

    /**
     * البند الأصلي من الفاتورة
     */
    public function saleItem()
    {
        return $this->belongsTo(SaleItem::class, 'sale_item_id');
    }

    /**
     * المنتج
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ═══════════════════════════════════════════════════
    // Boot Events
    // ═══════════════════════════════════════════════════

    protected static function boot()
    {
        parent::boot();

        // حساب المجاميع تلقائياً قبل الحفظ
        static::saving(function ($item) {
            $item->subtotal = $item->quantity * $item->unit_price;
            
            $discountAmount = $item->subtotal * ($item->discount / 100);
            $afterDiscount  = $item->subtotal - $discountAmount;
            
            $taxAmount = $afterDiscount * ($item->tax_rate / 100);
            
            $item->total = $afterDiscount + $taxAmount;
        });
    }

    // ═══════════════════════════════════════════════════
    // Helpers
    // ═══════════════════════════════════════════════════

    /**
     * مبلغ الخصم
     */
    public function calculateDiscountAmount()
    {
        return $this->subtotal * ($this->discount / 100);
    }

    /**
     * مبلغ الضريبة
     */
    public function calculateTaxAmount()
    {
        $afterDiscount = $this->subtotal - $this->calculateDiscountAmount();
        return $afterDiscount * ($this->tax_rate / 100);
    }
}