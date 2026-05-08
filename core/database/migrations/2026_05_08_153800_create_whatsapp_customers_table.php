
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_customers', function (Blueprint $table) {
            $table->id();
            
            // الروابط
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            
            // معلومات العميل
            $table->string('phone', 20);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            
            // بيانات Meta
            $table->string('whatsapp_profile_name')->nullable();
            $table->string('whatsapp_profile_picture', 500)->nullable();
            $table->string('whatsapp_id')->nullable();
            
            // التفضيلات
            $table->enum('preferred_language', ['ar', 'en'])->default('ar');
            $table->string('preferred_payment_method', 30)->nullable();
            $table->json('delivery_addresses')->nullable();
            $table->json('favorite_products')->nullable();
            
            // الإحصائيّات
            $table->integer('total_messages')->default(0);
            $table->integer('total_orders')->default(0);
            $table->integer('completed_orders')->default(0);
            $table->integer('cancelled_orders')->default(0);
            $table->decimal('total_spent', 12, 2)->default(0);
            $table->decimal('average_order_value', 10, 2)->default(0);
            
            // النشاط
            $table->timestamp('first_message_at')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamp('first_order_at')->nullable();
            $table->timestamp('last_order_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            
            // التصنيف
            $table->json('tags')->nullable();
            $table->enum('segment', ['new', 'regular', 'vip', 'inactive', 'churned'])->default('new');
            $table->integer('loyalty_points')->default(0);
            
            $table->text('merchant_notes')->nullable();
            
            // إعدادات التواصل
            $table->boolean('opt_in_marketing')->default(true);
            $table->boolean('opt_in_order_updates')->default(true);
            $table->boolean('is_blocked')->default(false);
            $table->text('block_reason')->nullable();
            
            // مصدر التسجيل
            $table->enum('acquisition_source', [
                'whatsapp_direct', 'web_storefront', 'qr_code',
                'shared_link', 'marketing_campaign', 'imported',
            ])->default('whatsapp_direct');
            
            $table->timestamps();
            
            // العلاقات
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            
            // قيود وفهارس
            $table->unique(['user_id', 'phone'], 'unique_user_phone');
            $table->index('phone');
            $table->index(['user_id', 'segment']);
            $table->index(['user_id', 'last_order_at']);
            $table->index('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_customers');
    }
};
