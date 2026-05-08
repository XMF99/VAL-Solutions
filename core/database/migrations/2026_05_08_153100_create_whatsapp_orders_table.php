<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * WhatsApp Store Module - Migration 2/5
 * 
 * جدول طلبات الواتساب
 * يستلم الطلب أوّلاً هنا، ثمّ يُحوّل لـ Sale (POS Order) عند التأكيد
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_orders', function (Blueprint $table) {
            $table->id();
            
            // الروابط الأساسيّة
            $table->unsignedBigInteger('company_id')->comment('التاجر');
            $table->string('order_number', 50)->unique()->comment('WS-12345');
            
            // الربط مع نظام OvoSale (يُملأ بعد التحويل)
            $table->unsignedBigInteger('customer_id')->nullable()->comment('FK to customers');
            $table->unsignedBigInteger('sale_id')->nullable()->comment('FK to sales - بعد التحويل لـ POS');
            $table->unsignedBigInteger('whatsapp_customer_id')->nullable()->comment('FK to whatsapp_customers');
            
            // بيانات العميل (لحظة الطلب — snapshot)
            $table->string('customer_name');
            $table->string('customer_phone', 20)->comment('رقم الواتساب');
            $table->string('customer_email')->nullable();
            $table->boolean('is_registered_customer')->default(false)->comment('هل عميل مسجّل في OvoSale؟');
            
            // نوع الطلب والتوصيل
            $table->enum('order_type', ['pickup', 'delivery', 'dine_in'])->default('delivery');
            $table->text('delivery_address')->nullable();
            $table->decimal('delivery_lat', 10, 7)->nullable();
            $table->decimal('delivery_lng', 10, 7)->nullable();
            $table->text('delivery_notes')->nullable();
            $table->string('delivery_area')->nullable();
            
            // المنتجات (JSON يحوي تفاصيل كل منتج)
            $table->json('items')->comment('[{product_id, name, price, qty, subtotal, image, notes}]');
            $table->integer('items_count')->default(0);
            
            // التسعير
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('coupon_code', 50)->nullable();
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(15.00)->comment('VAT %');
            $table->decimal('total', 10, 2)->default(0);
            
            // الدفع
            $table->enum('payment_method', [
                'cash', 'apple_pay', 'google_pay', 'mada', 'visa', 
                'mastercard', 'bank_transfer', 'wallet', 'unpaid'
            ])->default('cash');
            $table->enum('payment_status', [
                'pending', 'processing', 'paid', 'failed', 'refunded', 'cancelled'
            ])->default('pending');
            $table->text('payment_link')->nullable()->comment('Moyasar payment URL');
            $table->string('payment_id')->nullable()->comment('Moyasar/Gateway transaction ID');
            $table->json('payment_meta')->nullable()->comment('Gateway response data');
            $table->timestamp('paid_at')->nullable();
            
            // حالة الطلب (مع OvoSale POS)
            $table->enum('status', [
                'pending',          // جديد - بانتظار التاجر
                'confirmed',        // التاجر قبل
                'preparing',        // قيد التجهيز في المطبخ
                'ready',            // جاهز للاستلام/التوصيل
                'out_for_delivery', // مع المندوب
                'delivered',        // وصل العميل
                'completed',        // مكتمل
                'cancelled',        // ملغى
                'refunded',         // مرتجع
            ])->default('pending');
            $table->json('status_history')->nullable()->comment('سجل تغييرات الحالة');
            
            // مصدر الطلب وتتبّع المحادثة
            $table->enum('source', [
                'whatsapp_chat',      // محادثة مع البوت
                'whatsapp_catalog',   // كاتالوج Meta المدمج
                'web_storefront',     // متجر الويب /store/{slug}
            ])->default('whatsapp_chat');
            $table->string('whatsapp_message_id')->nullable()->comment('Meta Message ID');
            $table->string('conversation_id', 100)->nullable();
            
            // ملاحظات
            $table->text('customer_notes')->nullable()->comment('ملاحظات العميل');
            $table->text('merchant_notes')->nullable()->comment('ملاحظات التاجر');
            $table->text('cancellation_reason')->nullable();
            
            // الطوابع الزمنيّة المهمّة
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('prepared_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('expected_delivery_at')->nullable();
            
            $table->timestamps();
            
            // العلاقات
            $table->foreign('company_id')
                  ->references('id')->on('companies')
                  ->onDelete('cascade');
            
            // الفهارس (للأداء)
            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'created_at']);
            $table->index('customer_phone');
            $table->index('order_number');
            $table->index('payment_status');
            $table->index('whatsapp_message_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_orders');
    }
};
