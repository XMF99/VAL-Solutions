<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * WhatsApp Store Module - Migration 5/5
 * 
 * جدول المنتجات المنشورة على الواتساب
 * - يربط Product الموجود في OvoSale بـ Meta Catalog
 * - يسمح للتاجر بتخصيص المنتج خصّيصاً للواتساب
 * - يتتبّع المزامنة والإحصائيّات
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_published_products', function (Blueprint $table) {
            $table->id();
            
            // الروابط الأساسيّة
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('product_id')
                  ->comment('FK to products — منتج OvoSale الأصلي');
            $table->unsignedBigInteger('whatsapp_setting_id')->nullable()
                  ->comment('FK to whatsapp_store_settings');
            
            // معرّفات Meta
            $table->string('meta_product_retailer_id', 100)
                  ->comment('SKU نرسله لـ Meta — مثل: ovo_prod_123');
            $table->string('meta_product_id')->nullable()
                  ->comment('Meta Product ID بعد المزامنة');
            $table->string('meta_catalog_id')->nullable();
            
            // حالة النشر
            $table->boolean('is_published')->default(false)->comment('منشور على واتساب؟');
            $table->boolean('is_featured')->default(false)->comment('مميّز في الكاتالوج');
            $table->integer('display_order')->default(0)->comment('ترتيب العرض');
            
            // تخصيصات خاصّة بالواتساب (override للمنتج الأصلي)
            $table->string('whatsapp_name')->nullable()
                  ->comment('اسم بديل للواتساب — إذا فارغ يستخدم اسم المنتج الأصلي');
            $table->text('whatsapp_description')->nullable()
                  ->comment('وصف بديل (Meta يدعم 9999 حرف)');
            $table->decimal('whatsapp_price', 10, 2)->nullable()
                  ->comment('سعر بديل (للهامش على التوصيل) — إذا فارغ يستخدم السعر الأصلي');
            $table->decimal('whatsapp_sale_price', 10, 2)->nullable()
                  ->comment('سعر التخفيض على الواتساب');
            
            // الصور (Meta يدعم حتى 10 صور)
            $table->string('whatsapp_image_url', 1000)->nullable()
                  ->comment('صورة رئيسيّة (override) — Meta يطلب 500x500 على الأقلّ');
            $table->json('additional_images')->nullable()
                  ->comment('صور إضافيّة [url1, url2, ...]');
            
            // معلومات Meta-specific
            $table->string('meta_category', 100)->nullable()
                  ->comment('Meta Product Category Taxonomy');
            $table->string('whatsapp_brand')->nullable();
            $table->string('whatsapp_url', 1000)->nullable()
                  ->comment('رابط المنتج في الويب (للعرض في Meta)');
            
            // التوفّر
            $table->enum('availability', [
                'in_stock',         // متوفّر
                'out_of_stock',     // نفذ
                'preorder',         // طلب مسبق
                'discontinued',     // متوقّف
            ])->default('in_stock');
            
            // الحدود (Quantity Limits)
            $table->integer('min_qty')->default(1)->comment('الحدّ الأدنى للطلب');
            $table->integer('max_qty')->nullable()->comment('الحدّ الأقصى للطلب');
            
            // الخصائص (Variants / Options)
            $table->boolean('requires_options')->default(false)
                  ->comment('هل يحتاج العميل يختار خيارات؟ (حجم، لون...)');
            $table->json('options_data')->nullable()
                  ->comment('بيانات الخيارات والـ variants');
            
            // حالة المزامنة مع Meta
            $table->enum('sync_status', [
                'pending',    // بانتظار المزامنة
                'syncing',    // قيد المزامنة
                'synced',     // متزامن
                'failed',     // فشل
                'unpublished',// تمّ إلغاء النشر
            ])->default('pending');
            $table->text('sync_error')->nullable();
            $table->integer('sync_retries')->default(0);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamp('next_sync_at')->nullable();
            
            // الإحصائيّات (للتحليلات)
            $table->integer('view_count')->default(0)->comment('مرّات عرض المنتج');
            $table->integer('add_to_cart_count')->default(0);
            $table->integer('order_count')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->timestamp('last_ordered_at')->nullable();
            
            // ملاحظات
            $table->text('merchant_notes')->nullable();
            
            $table->timestamps();
            
            // العلاقات
            $table->foreign('company_id')
                  ->references('id')->on('companies')
                  ->onDelete('cascade');
            
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
            
            $table->foreign('whatsapp_setting_id')
                  ->references('id')->on('whatsapp_store_settings')
                  ->onDelete('set null');
            
            // قيود ومفاتيح فريدة
            $table->unique(['company_id', 'product_id'], 'unique_company_product');
            $table->unique('meta_product_retailer_id', 'unique_meta_retailer_id');
            
            // الفهارس
            $table->index(['company_id', 'is_published']);
            $table->index(['company_id', 'sync_status']);
            $table->index('meta_product_id');
            $table->index(['is_published', 'display_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_published_products');
    }
};
