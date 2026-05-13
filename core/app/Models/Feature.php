<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_premium' => 'boolean',
        'status'     => 'integer',
        'sort_order' => 'integer',
    ];

    // ═══════════════════════════════════════════════════════════
    // Relationships
    // ═══════════════════════════════════════════════════════════

    public function plans()
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'plan_features', 'feature_id', 'plan_id')
            ->withPivot(['is_enabled', 'limit_value', 'settings'])
            ->withTimestamps();
    }

    public function planFeatures()
    {
        return $this->hasMany(PlanFeature::class);
    }

    // ═══════════════════════════════════════════════════════════
    // Scopes
    // ═══════════════════════════════════════════════════════════

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // ═══════════════════════════════════════════════════════════
    // Static helpers
    // ═══════════════════════════════════════════════════════════

    /**
     * تحقّق إذا الباقة فيها هذي الميزة
     */
    public static function isAvailableForPlan(string $featureCode, int $planId): bool
    {
        $feature = static::where('code', $featureCode)->first();
        if (!$feature) return false;

        return PlanFeature::where('feature_id', $feature->id)
            ->where('plan_id', $planId)
            ->where('is_enabled', true)
            ->exists();
    }

    /**
     * الـcategories المتاحة
     */
    public static function getCategories(): array
    {
        return [
            'sales'      => 'المبيعات',
            'pos'        => 'نقطة البيع',
            'customers'  => 'العملاء',
            'inventory'  => 'المخزون',
            'purchases'  => 'المشتريات',
            'finance'    => 'المالية والمحاسبة',
            'reports'    => 'التقارير',
            'whatsapp'   => 'WhatsApp',
            'hrm'        => 'الموظفين',
            'branches'   => 'الفروع',
            'settings'   => 'الإعدادات',
        ];
    }

    public function getCategoryLabelAttribute(): string
    {
        return static::getCategories()[$this->category] ?? $this->category;
    }
}
