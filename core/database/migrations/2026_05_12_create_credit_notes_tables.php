<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إنشاء جداول إشعارات دائنة (Credit Notes)
     * 
     * النمط يتبع جداول sales/sale_details بدقّة
     */
    public function up(): void
    {
        // ─── الجدول الرئيسي ───
        Schema::create('credit_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('credit_note_number')->nullable();
            $table->date('credit_note_date')->nullable();
            
            // ربط بالفاتورة الأصليّة (اختياري — قد يكون إشعار مستقلّ)
            $table->unsignedBigInteger('sale_id')->default(0)->comment('الفاتورة الأصليّة');
            $table->string('original_invoice_number')->nullable();
            
            $table->unsignedInteger('customer_id')->default(0);
            $table->unsignedInteger('warehouse_id')->default(0);
            
            // الخصومات والشحن (مثل sales)
            $table->tinyInteger('discount_type')->nullable();
            $table->decimal('discount_value', 28, 8)->default(0);
            $table->decimal('discount_amount', 28, 8)->default(0);
            $table->decimal('shipping_amount', 28, 8)->default(0);
            
            // المبالغ
            $table->decimal('subtotal', 28, 8)->default(0);
            $table->decimal('total', 28, 8)->default(0)->comment('قيمة الإشعار الكاملة');
            $table->decimal('applied_amount', 28, 8)->default(0)->comment('المبلغ المُطبّق على رصيد العميل');
            $table->decimal('refunded_amount', 28, 8)->default(0)->comment('المبلغ المُسترجع نقداً');
            $table->decimal('balance_amount', 28, 8)->default(0)->comment('الرصيد المتبقي للعميل');
            
            // السبب والملاحظات
            $table->string('reason')->nullable()->comment('سبب الإشعار: return, damage, discount, error, other');
            $table->text('note')->nullable();
            
            // الحالة
            $table->unsignedInteger('issued_by')->default(0);
            $table->tinyInteger('status')->default(1)->comment('1=active, 0=cancelled, 2=fully_applied');
            $table->boolean('affects_inventory')->default(true)->comment('هل يرجع المخزون أم لا');
            
            $table->timestamps();
            
            $table->index(['user_id', 'credit_note_date']);
            $table->index(['user_id', 'customer_id']);
            $table->index(['user_id', 'sale_id']);
            $table->index(['user_id', 'status']);
        });

        // ─── جدول التفاصيل (سطور المنتجات) ───
        Schema::create('credit_note_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('credit_note_id');
            
            $table->unsignedInteger('product_id')->default(0);
            $table->unsignedInteger('product_details_id')->default(0);
            
            // الضرائب (مثل sale_details)
            $table->unsignedInteger('tax_id')->default(0);
            $table->tinyInteger('tax_type')->default(0);
            $table->decimal('tax_amount', 28, 8)->default(0);
            $table->decimal('tax_percentage', 5, 2)->default(0);
            
            // الخصومات
            $table->tinyInteger('discount_type')->default(0);
            $table->decimal('discount_value', 28, 8)->default(0);
            $table->decimal('discount_amount', 28, 8)->default(0);
            
            // الأسعار والكميّة
            $table->decimal('purchase_price', 28, 8)->default(0);
            $table->decimal('unit_price', 28, 8)->default(0);
            $table->decimal('sale_price', 28, 8)->default(0);
            $table->integer('quantity')->default(0);
            $table->decimal('subtotal', 28, 8)->default(0);
            
            // ربط بسطر الفاتورة الأصليّة (لتتبّع الإرجاع)
            $table->unsignedBigInteger('original_sale_detail_id')->nullable();
            
            $table->timestamps();
            
            $table->index('credit_note_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_note_details');
        Schema::dropIfExists('credit_notes');
    }
};
