
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_orders', function (Blueprint $table) {
            $table->id();
            
            // الروابط الأساسيّة (User = التاجر)
            $table->unsignedBigInteger('user_id');
            $table->string('order_number', 50)->unique();
            
            // الربط مع OvoSale
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->unsignedBigInteger('whatsapp_customer_id')->nullable();
            
            // بيانات العميل
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->string('customer_email')->nullable();
            $table->boolean('is_registered_customer')->default(false);
            
            // نوع الطلب والتوصيل
            $table->enum('order_type', ['pickup', 'delivery', 'dine_in'])->default('delivery');
            $table->text('delivery_address')->nullable();
            $table->decimal('delivery_lat', 10, 7)->nullable();
            $table->decimal('delivery_lng', 10, 7)->nullable();
            $table->text('delivery_notes')->nullable();
            $table->string('delivery_area')->nullable();
            
            // المنتجات والتسعير
            $table->json('items');
            $table->integer('items_count')->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('coupon_code', 50)->nullable();
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(15.00);
            $table->decimal('total', 10, 2)->default(0);
            
            // الدفع
            $table->enum('payment_method', [
                'cash', 'apple_pay', 'google_pay', 'mada', 'visa', 
                'mastercard', 'bank_transfer', 'wallet', 'unpaid'
            ])->default('cash');
            $table->enum('payment_status', [
                'pending', 'processing', 'paid', 'failed', 'refunded', 'cancelled'
            ])->default('pending');
            $table->text('payment_link')->nullable();
            $table->string('payment_id')->nullable();
            $table->json('payment_meta')->nullable();
            $table->timestamp('paid_at')->nullable();
            
            // الحالة
            $table->enum('status', [
                'pending', 'confirmed', 'preparing', 'ready', 
                'out_for_delivery', 'delivered', 'completed', 
                'cancelled', 'refunded',
            ])->default('pending');
            $table->json('status_history')->nullable();
            
            // المصدر
            $table->enum('source', [
                'whatsapp_chat', 'whatsapp_catalog', 'web_storefront',
            ])->default('whatsapp_chat');
            $table->string('whatsapp_message_id')->nullable();
            $table->string('conversation_id', 100)->nullable();
            
            // ملاحظات
            $table->text('customer_notes')->nullable();
            $table->text('merchant_notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            // الطوابع الزمنيّة
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('prepared_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('expected_delivery_at')->nullable();
            
            $table->timestamps();
            
            // العلاقات
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            
            // الفهارس
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'created_at']);
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
