<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Company;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\WhatsappStoreSetting;
use App\Models\WhatsappOrder;
use App\Models\WhatsappCustomer;
use App\Models\WhatsappMessage;
use App\Models\WhatsappPublishedProduct;

/**
 * WhatsApp Module - Service Provider
 * 
 * يضيف علاقات ودوال WhatsApp للموديلات الموجودة في OvoSale
 * بدون تعديل أيّ ملفّ موجود — كل شي هنا في مكان واحد
 * 
 * المسار: core/app/Providers/WhatsappModuleServiceProvider.php
 */
class WhatsappModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerCompanyRelations();
        $this->registerProductRelations();
        $this->registerCustomerRelations();
        $this->registerSaleRelations();
        $this->registerHelperMacros();
    }

    /**
     * علاقات Company (التاجر)
     * --------------------------------------------------
     * Usage:
     *   $company->whatsappSetting           → الإعدادات
     *   $company->whatsappOrders            → كل الطلبات
     *   $company->whatsappCustomers         → كل العملاء
     *   $company->whatsappPublishedProducts → المنتجات المنشورة
     *   $company->whatsappMessages          → كل الرسائل
     */
    private function registerCompanyRelations(): void
    {
        Company::resolveRelationUsing('whatsappSetting', function ($model) {
            return $model->hasOne(WhatsappStoreSetting::class, 'company_id');
        });

        Company::resolveRelationUsing('whatsappOrders', function ($model) {
            return $model->hasMany(WhatsappOrder::class, 'company_id');
        });

        Company::resolveRelationUsing('whatsappCustomers', function ($model) {
            return $model->hasMany(WhatsappCustomer::class, 'company_id');
        });

        Company::resolveRelationUsing('whatsappPublishedProducts', function ($model) {
            return $model->hasMany(WhatsappPublishedProduct::class, 'company_id');
        });

        Company::resolveRelationUsing('whatsappMessages', function ($model) {
            return $model->hasMany(WhatsappMessage::class, 'company_id');
        });
    }

    /**
     * علاقات Product (المنتجات)
     * --------------------------------------------------
     * Usage:
     *   $product->whatsappPublication       → السجل المنشور (إذا موجود)
     *   $product->isPublishedOnWhatsapp()   → boolean
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
                'company_id' => $this->company_id,
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
     * علاقات Customer (العميل)
     * --------------------------------------------------
     * Usage:
     *   $customer->whatsappProfile     → ملفّ العميل في الواتس اب
     *   $customer->whatsappOrders      → طلباته من الواتس اب
     *   $customer->isOnWhatsapp()      → boolean
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
     * علاقات Sale (الطلب في POS)
     * --------------------------------------------------
     * Usage:
     *   $sale->whatsappOrder           → الطلب الأصلي من الواتس اب (إذا موجود)
     *   $sale->isFromWhatsapp()        → boolean
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
        // Company helpers
        Company::macro('hasWhatsappEnabled', function () {
            /** @var \App\Models\Company $this */
            return $this->whatsappSetting 
                && $this->whatsappSetting->is_active 
                && $this->whatsappSetting->isConnected();
        });

        Company::macro('whatsappStoreUrl', function () {
            /** @var \App\Models\Company $this */
            return $this->whatsappSetting?->publicStoreUrl();
        });

        Company::macro('todayWhatsappOrdersCount', function () {
            /** @var \App\Models\Company $this */
            return $this->whatsappOrders()->whereDate('created_at', today())->count();
        });

        Company::macro('pendingWhatsappOrdersCount', function () {
            /** @var \App\Models\Company $this */
            return $this->whatsappOrders()->where('status', 'pending')->count();
        });
    }

    public function register(): void
    {
        // لا حاجة لشيء هنا
    }
}
