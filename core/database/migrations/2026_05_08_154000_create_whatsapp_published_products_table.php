
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_published_products', function (Blueprint $table) {
            $table->id();
            
            // الروابط
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('whatsapp_setting_id')->nullable();
            
            // معرّفات Meta
            $table->string('meta_product_retailer_id', 100);
            $table->string('meta_product_id')->nullable();
            $table->string('meta_catalog_id')->nullable();
            
            // حالة النشر
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('display_order')->default(0);
            
            // التخصيصات
            $table->string('whatsapp_name')->nullable();
            $table->text('whatsapp_description')->nullable();
            $table->decimal('whatsapp_price', 10, 2)->nullable();
            $table->decimal('whatsapp_sale_price', 10, 2)->nullable();
            $table->string('whatsapp_image_url', 1000)->nullable();
            $table->json('additional_images')->nullable();
            
            // معلومات Meta
            $table->string('meta_category', 100)->nullable();
            $table->string('whatsapp_brand')->nullable();
            $table->string('whatsapp_url', 1000)->nullable();
            
            // التوفّر والكميّات
            $table->enum('availability', [
                'in_stock', 'out_of_stock', 'preorder', 'discontinued',
            ])->default('in_stock');
            $table->integer('min_qty')->default(1);
            $table->integer('max_qty')->nullable();
            
            // الخيارات
            $table->boolean('requires_options')->default(false);
            $table->json('options_data')->nullable();
            
            // المزامنة
            $table->enum('sync_status', [
                'pending', 'syncing', 'synced', 'failed', 'unpublished',
            ])->default('pending');
            $table->text('sync_error')->nullable();
            $table->integer('sync_retries')->default(0);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamp('next_sync_at')->nullable();
            
            // الإحصائيّات
            $table->integer('view_count')->default(0);
            $table->integer('add_to_cart_count')->default(0);
            $table->integer('order_count')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->timestamp('last_ordered_at')->nullable();
            
            $table->text('merchant_notes')->nullable();
            
            $table->timestamps();
            
            // العلاقات
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
            
            $table->foreign('whatsapp_setting_id')
                  ->references('id')->on('whatsapp_store_settings')
                  ->onDelete('set null');
            
            // قيود وفهارس
            $table->unique(['user_id', 'product_id'], 'unique_user_product');
            $table->unique('meta_product_retailer_id', 'unique_meta_retailer_id');
            $table->index(['user_id', 'is_published']);
            $table->index(['user_id', 'sync_status']);
            $table->index('meta_product_id');
            $table->index(['is_published', 'display_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_published_products');
    }
};
