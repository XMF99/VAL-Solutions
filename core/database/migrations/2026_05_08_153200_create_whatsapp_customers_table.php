<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * WhatsApp Store Module - Migration 3/5
 * 
 * جدول عملاء الواتساب
 * - يُنشأ تلقائياً عند أوّل رسالة من العميل
 * - يربط مع Customer الموجود في OvoSale (إذا الرقم متطابق)
 * - يتتبّع سلوك العميل وتفضيلاته
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_customers', function (Blueprint $table) {
            $table->id();
            
            // الروابط
            $table->unsignedBigInteger('company_id')->comment('التاجر');
            $table->unsignedBigInteger('customer_id')->nullable()
                  ->comment('FK to customers — يُملأ عند تطابق الجوّال');
            
            // معلومات العميل الأساسيّة
            $table->string('phone', 20)->comment('رقم الواتساب — مفتاح أساسي للبحث');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            
            // معلومات من WhatsApp Profile
            $table->string('whatsapp_profile_name')->nullable()->comment('الاسم الظاهر في واتساب');
            $table->string('whatsapp_profile_picture', 500)->nullable();
            $table->string('whatsapp_id')->nullable()->comment('Meta User ID');
            
            // التفضيلات
            $table->enum('preferred_language', ['ar', 'en'])->default('ar');
            $table->string('preferred_payment_method', 30)->nullable();
            $table->json('delivery_addresses')->nullable()
                  ->comment('عناوين محفوظة: [{label, address, lat, lng, is_default}]');
            $table->json('favorite_products')->nullable()
                  ->comment('منتجات الطلبات المتكرّرة: [product_ids]');
            
            // إحصائيّات (تحدّث تلقائياً مع كل طلب)
            $table->integer('total_messages')->default(0);
            $table->integer('total_orders')->default(0);
            $table->integer('completed_orders')->default(0);
            $table->integer('cancelled_orders')->default(0);
            $table->decimal('total_spent', 12, 2)->default(0);
            $table->decimal('average_order_value', 10, 2)->default(0);
            
            // التفاعل والنشاط
            $table->timestamp('first_message_at')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamp('first_order_at')->nullable();
            $table->timestamp('last_order_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            
            // التصنيف والتجزئة (Segmentation)
            $table->json('tags')->nullable()->comment('["VIP", "frequent", "new", "inactive"]');
            $table->enum('segment', ['new', 'regular', 'vip', 'inactive', 'churned'])->default('new');
            $table->integer('loyalty_points')->default(0)->comment('للنظام لاحقاً');
            
            // ملاحظات التاجر
            $table->text('merchant_notes')->nullable();
            
            // إعدادات التواصل
            $table->boolean('opt_in_marketing')->default(true)->comment('يقبل رسائل تسويقيّة');
            $table->boolean('opt_in_order_updates')->default(true)->comment('يقبل تحديثات الطلب');
            $table->boolean('is_blocked')->default(false);
            $table->text('block_reason')->nullable();
            
            // مصدر التسجيل
            $table->enum('acquisition_source', [
                'whatsapp_direct',    // كتب للتاجر مباشرة
                'web_storefront',     // من متجر الويب
                'qr_code',            // مسح QR
                'shared_link',        // رابط من شخص ثاني
                'marketing_campaign', // حملة تسويقيّة
                'imported',           // مستورد من OvoSale
            ])->default('whatsapp_direct');
            
            $table->timestamps();
            
            // العلاقات
            $table->foreign('company_id')
                  ->references('id')->on('companies')
                  ->onDelete('cascade');
            
            // قيود ومفاتيح فريدة
            $table->unique(['company_id', 'phone'], 'unique_company_phone');
            
            // الفهارس
            $table->index('phone');
            $table->index(['company_id', 'segment']);
            $table->index(['company_id', 'last_order_at']);
            $table->index('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_customers');
    }
};
