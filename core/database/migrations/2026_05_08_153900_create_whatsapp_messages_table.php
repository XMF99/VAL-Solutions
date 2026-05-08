
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            
            // الروابط
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('whatsapp_customer_id');
            $table->string('conversation_id', 100)->nullable();
            
            // اتجاه الرسالة
            $table->enum('direction', ['inbound', 'outbound']);
            
            // نوع الرسالة
            $table->enum('message_type', [
                'text', 'image', 'audio', 'video', 'document',
                'location', 'sticker', 'contacts', 'interactive',
                'template', 'order', 'reaction', 'button', 'system', 'unknown',
            ]);
            
            // معرّفات Meta
            $table->string('meta_message_id', 200)->nullable();
            $table->string('meta_phone_number_id')->nullable();
            
            // الحالة
            $table->enum('status', [
                'queued', 'sent', 'delivered', 'read', 'failed', 'received',
            ])->default('queued');
            
            // المحتوى
            $table->text('content')->nullable();
            
            // الوسائط
            $table->string('media_url', 1000)->nullable();
            $table->string('media_mime_type', 100)->nullable();
            $table->string('media_filename')->nullable();
            $table->string('media_id')->nullable();
            $table->integer('media_size_bytes')->nullable();
            
            // الموقع
            $table->decimal('location_lat', 10, 7)->nullable();
            $table->decimal('location_lng', 10, 7)->nullable();
            $table->string('location_name')->nullable();
            $table->string('location_address')->nullable();
            
            // التفاعل
            $table->enum('interactive_type', [
                'button_reply', 'list_reply', 'product',
                'product_list', 'cta_url', 'flow',
            ])->nullable();
            $table->json('interactive_payload')->nullable();
            
            // الطلبات من الكاتالوج
            $table->json('order_data')->nullable();
            $table->unsignedBigInteger('whatsapp_order_id')->nullable();
            
            // القوالب
            $table->string('template_name')->nullable();
            $table->string('template_language', 10)->nullable();
            $table->json('template_components')->nullable();
            
            // الردود
            $table->string('replied_to_meta_id', 200)->nullable();
            $table->unsignedBigInteger('replied_to_message_id')->nullable();
            
            // معالجة البوت
            $table->boolean('is_from_bot')->default(false);
            $table->boolean('is_handled')->default(false);
            $table->string('handler_type', 30)->nullable();
            $table->unsignedBigInteger('handler_user_id')->nullable();
            $table->string('intent', 50)->nullable();
            
            // الأخطاء
            $table->integer('error_code')->nullable();
            $table->text('error_message')->nullable();
            $table->json('error_data')->nullable();
            $table->integer('retry_count')->default(0);
            
            // الطوابع الزمنيّة
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            
            // التكلفة
            $table->decimal('cost_usd', 6, 4)->nullable();
            $table->enum('conversation_category', [
                'marketing', 'utility', 'authentication', 'service',
            ])->nullable();
            
            $table->timestamps();
            
            // العلاقات
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            
            $table->foreign('whatsapp_customer_id')
                  ->references('id')->on('whatsapp_customers')
                  ->onDelete('cascade');
            
            // الفهارس
            $table->index(['user_id', 'whatsapp_customer_id', 'created_at'], 'idx_conversation');
            $table->index(['user_id', 'direction', 'created_at']);
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
