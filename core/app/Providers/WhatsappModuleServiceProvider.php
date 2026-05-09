<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\WhatsappStoreSetting;
use App\Models\WhatsappOrder;
use App\Models\WhatsappCustomer;
use App\Models\WhatsappMessage;
use App\Models\WhatsappPublishedProduct;

/**
 * WhatsApp Module - Service Provider V2
 * 
 * يضيف علاقات WhatsApp لـ User بدل Company
 * (في OvoSale، التاجر = User)
 * 
 * المسار: core/app/Providers/WhatsappModuleServiceProvider.php
 */
class WhatsappModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerUserRelations();
        $this->registerProductRelations();
        $this->registerCustomerRelations();
        $this->registerSaleRelations();
        $this->registerHelperMacros();
    }

    /**
     * علاقات User (التاجر)
     * --------------------------------------------------
     * Usage:
     *   $user->whatsappSetting              → الإعدادات
     *   $user->whatsappOrders               → كل الطلبات
     *   $user->whatsappCustomers            → كل العملاء
     *   $user->whatsappPublishedProducts    → المنتجات المنشورة
     *   $user->whatsappMessages             → كل الرسائل
     */
    private function registerUserRelations(): void
    {
        User::resolveRelationUsing('whatsappSetting', function ($model) {
            return $model->hasOne(WhatsappStoreSetting::class, 'user_id');
        });

        User::resolveRelationUsing('whatsappOrders', function ($model) {
            return $model->hasMany(WhatsappOrder::class, 'user_id');
        });

        User::resolveRelationUsing('whatsappCustomers', function ($model) {
            return $model->hasMany(WhatsappCustomer::class, 'user_id');
        });

        User::resolveRelationUsing('whatsappPublishedProducts', function ($model) {
            return $model->hasMany(WhatsappPublishedProduct::class, 'user_id');
        });

        User::resolveRelationUsing('whatsappMessages', function ($model) {
            return $model->hasMany(WhatsappMessage::class, 'user_id');
        });
    }

    /**
     * علاقات Product
     * --------------------------------------------------
     * Usage:
     *   $product->whatsappPublication       → السجل المنشور
     *   $product->isPublishedOnWhatsapp()   → boolean
     *   $product->publishToWhatsapp()       → نشر
     *   $product->unpublishFromWhatsapp()   → إخفاء
     */
    private function registerProductRelations(): void
    {
        Product::resolveRelationUsing('whatsappPublication', function ($model) {
            return $model->hasOne(WhatsappPublishedProduct::class, 'product_id');
        });

        Product::macro('isPublishedOnWhatsapp', function () {
            /** @var \App\Models\Product $this */
            return $this->whatsappPublication 
                && $this->whatsappPublication->is_published;
        });

        Product::macro('publishToWhatsapp', function (array $overrides = []) {
            /** @var \App\Models\Product $this */
            $publication = $this->whatsappPublication ?? new WhatsappPublishedProduct([
                'user_id' => $this->user_id,
                'product_id' => $this->id,
            ]);
            
            $publication->fill(array_merge([
                'is_published' => true,
                'sync_status' => 'pending',
            ], $overrides));
            
            $publication->save();
            return $publication;
        });

        Product::macro('unpublishFromWhatsapp', function () {
            /** @var \App\Models\Product $this */
            if ($this->whatsappPublication) {
                $this->whatsappPublication->update([
                    'is_published' => false,
                    'sync_status' => 'unpublished',
                ]);
            }
            return $this;
        });
    }

    /**
     * علاقات Customer
     * --------------------------------------------------
     * Usage:
     *   $customer->whatsappProfile          → ملفّ العميل في الواتس اب
     *   $customer->whatsappOrders           → طلباته من الواتس اب
     *   $customer->isOnWhatsapp()           → boolean
     */
    private function registerCustomerRelations(): void
    {
        Customer::resolveRelationUsing('whatsappProfile', function ($model) {
            return $model->hasOne(WhatsappCustomer::class, 'customer_id');
        });

        Customer::resolveRelationUsing('whatsappOrders', function ($model) {
            return $model->hasMany(WhatsappOrder::class, 'customer_id');
        });

        Customer::macro('isOnWhatsapp', function () {
            /** @var \App\Models\Customer $this */
            return (bool) $this->whatsappProfile;
        });
    }

    /**
     * علاقات Sale
     * --------------------------------------------------
     * Usage:
     *   $sale->whatsappOrder                → الطلب الأصلي من الواتس اب
     *   $sale->isFromWhatsapp()             → boolean
     */
    private function registerSaleRelations(): void
    {
        Sale::resolveRelationUsing('whatsappOrder', function ($model) {
            return $model->hasOne(WhatsappOrder::class, 'sale_id');
        });

        Sale::macro('isFromWhatsapp', function () {
            /** @var \App\Models\Sale $this */
            return (bool) $this->whatsappOrder;
        });

        Sale::macro('whatsappSource', function () {
            /** @var \App\Models\Sale $this */
            return $this->whatsappOrder?->source;
        });
    }

    /**
     * Helper Macros إضافيّة
     * --------------------------------------------------
     */
    private function registerHelperMacros(): void
    {
        User::macro('hasWhatsappEnabled', function () {
            /** @var \App\Models\User $this */
            return $this->whatsappSetting 
                && $this->whatsappSetting->is_active 
                && $this->whatsappSetting->isConnected();
        });

        User::macro('whatsappStoreUrl', function () {
            /** @var \App\Models\User $this */
            return $this->whatsappSetting?->publicStoreUrl();
        });

        User::macro('todayWhatsappOrdersCount', function () {
            /** @var \App\Models\User $this */
            return $this->whatsappOrders()->whereDate('created_at', today())->count();
        });

        User::macro('pendingWhatsappOrdersCount', function () {
            /** @var \App\Models\User $this */
            return $this->whatsappOrders()->where('status', 'pending')->count();
        });
    }

    public function register(): void
    {
        // لا حاجة لشيء هنا
    }
}
