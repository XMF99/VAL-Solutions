<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * WhatsApp Store Module - Migration 4/5
 * 
 * جدول رسائل الواتساب
 * - يحفظ كل رسالة (واردة وصادرة)
 * - يدعم جميع أنواع رسائل Meta Cloud API
 * - أساس البوت + سجل المحادثة + التحليلات
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            
            // الروابط الأساسيّة
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('whatsapp_customer_id');
            $table->string('conversation_id', 100)->nullable()
                  ->comment('Meta Conversation ID — نافذة 24 ساعة');
            
            // اتجاه الرسالة
            $table->enum('direction', ['inbound', 'outbound'])
                  ->comment('inbound: من العميل / outbound: من التاجر أو البوت');
            
            // نوع الرسالة (كل أنواع Meta Cloud API)
            $table->enum('message_type', [
                'text',           // نصّ عادي
                'image',          // صورة
                'audio',          // صوت
                'video',          // فيديو
                'document',       // ملفّ
                'location',       // موقع
                'sticker',        // ملصق
                'contacts',       // جهات اتصال
                'interactive',    // أزرار / قوائم
                'template',       // قالب جاهز (outbound فقط)
                'order',          // طلب من الكاتالوج ⭐
                'reaction',       // إيموجي ردّ
                'button',         // ضغط زرّ
                'system',         // رسائل النظام
                'unknown',        // غير معروف
            ]);
            
            // معرّفات Meta
            $table->string('meta_message_id', 200)->nullable()
                  ->comment('wamid من Meta — فريد لكل رسالة');
            $table->string('meta_phone_number_id')->nullable();
            
            // حالة الرسالة (لـ outbound)
            $table->enum('status', [
                'queued',     // في الطابور
                'sent',       // أُرسلت
                'delivered',  // وصلت للجهاز
                'read',       // قرأها العميل
                'failed',     // فشلت
                'received',   // تمّ استلامها (inbound)
            ])->default('queued');
            
            // المحتوى النصّي
            $table->text('content')->nullable()->comment('النصّ أو caption للوسائط');
            
            // الوسائط (Media)
            $table->string('media_url', 1000)->nullable();
            $table->string('media_mime_type', 100)->nullable();
            $table->string('media_filename')->nullable();
            $table->string('media_id')->nullable()->comment('Meta Media ID');
            $table->integer('media_size_bytes')->nullable();
            
            // الموقع (Location)
            $table->decimal('location_lat', 10, 7)->nullable();
            $table->decimal('location_lng', 10, 7)->nullable();
            $table->string('location_name')->nullable();
            $table->string('location_address')->nullable();
            
            // الرسائل التفاعليّة (Interactive)
            $table->enum('interactive_type', [
                'button_reply',     // ضغط زرّ
                'list_reply',       // اختيار من قائمة
                'product',          // عرض منتج واحد
                'product_list',     // عرض قائمة منتجات (Multi-Product)
                'cta_url',          // زرّ رابط
                'flow',             // Meta Flow
            ])->nullable();
            $table->json('interactive_payload')->nullable()
                  ->comment('بيانات التفاعل: {id, title, description, products: [...]}');
            
            // الطلبات من الكاتالوج (Order Messages)
            $table->json('order_data')->nullable()
                  ->comment('عند نوع order: {catalog_id, product_items: [{product_retailer_id, quantity, item_price, currency}]}');
            $table->unsignedBigInteger('whatsapp_order_id')->nullable()
                  ->comment('FK to whatsapp_orders — عند تحويل order message لطلب');
            
            // القوالب (Templates - للرسائل الصادرة)
            $table->string('template_name')->nullable();
            $table->string('template_language', 10)->nullable();
            $table->json('template_components')->nullable()
                  ->comment('parameters المرسلة مع القالب');
            
            // الردود (Reply Context)
            $table->string('replied_to_meta_id', 200)->nullable()
                  ->comment('Meta ID للرسالة المردود عليها');
            $table->unsignedBigInteger('replied_to_message_id')->nullable()
                  ->comment('FK داخلي للرسالة الأصليّة');
            
            // معالجة البوت
            $table->boolean('is_from_bot')->default(false)->comment('رسالة آليّة من البوت؟');
            $table->boolean('is_handled')->default(false)->comment('هل ردّ عليها البوت/التاجر؟');
            $table->string('handler_type', 30)->nullable()
                  ->comment('bot / merchant / ai / template');
            $table->unsignedBigInteger('handler_user_id')->nullable()
                  ->comment('User ID إذا التاجر ردّ يدوياً');
            $table->string('intent', 50)->nullable()
                  ->comment('نيّة الرسالة: greeting, browse, order, complaint, support');
            
            // الأخطاء (لـ failed messages)
            $table->integer('error_code')->nullable();
            $table->text('error_message')->nullable();
            $table->json('error_data')->nullable();
            $table->integer('retry_count')->default(0);
            
            // الطوابع الزمنيّة
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            
            // تكلفة الرسالة (للمحاسبة لاحقاً)
            $table->decimal('cost_usd', 6, 4)->nullable()
                  ->comment('تكلفة Meta للمحادثة (Marketing/Utility/Service)');
            $table->enum('conversation_category', [
                'marketing', 'utility', 'authentication', 'service'
            ])->nullable();
            
            $table->timestamps();
            
            // العلاقات
            $table->foreign('company_id')
                  ->references('id')->on('companies')
                  ->onDelete('cascade');
            
            $table->foreign('whatsapp_customer_id')
                  ->references('id')->on('whatsapp_customers')
                  ->onDelete('cascade');
            
            // الفهارس (مهمّة للأداء — جدول كبير)
            $table->index(['company_id', 'whatsapp_customer_id', 'created_at'], 'idx_conversation');
            $table->index(['company_id', 'direction', 'created_at']);
            $table->index('meta_message_id');
            $table->index('conversation_id');
            $table->index(['is_handled', 'direction']);
            $table->index('whatsapp_order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_messages');
    }
};
