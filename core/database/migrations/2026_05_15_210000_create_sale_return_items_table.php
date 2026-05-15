<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * إنشاء جدول sale_return_items (بنود المرتجعات)
     */
    public function up(): void
    {
        if (Schema::hasTable('sale_return_items')) {
            return; // الجدول موجود — لا نسوّي شي
        }

        Schema::create('sale_return_items', function (Blueprint $t) {
            $t->id();

            // ─── الارتباطات ───
            $t->unsignedBigInteger('sale_return_id')->index();
            $t->unsignedBigInteger('sale_item_id')->nullable()->index()->comment('البند الأصلي من الفاتورة');
            $t->unsignedBigInteger('product_id')->nullable()->index();

            // ─── معلومات المنتج ───
            $t->string('product_name');

            // ─── الكميّات والأسعار ───
            $t->decimal('quantity', 15, 2)->default(1);
            $t->decimal('unit_price', 15, 2)->default(0);

            // ─── الخصم والضريبة (نسبة مئويّة) ───
            $t->decimal('discount', 8, 2)->default(0)->comment('نسبة مئويّة %');
            $t->decimal('tax_rate', 8, 2)->default(0)->comment('نسبة الضريبة %');

            // ─── المجاميع المحسوبة ───
            $t->decimal('subtotal', 15, 2)->default(0)->comment('قبل الخصم والضريبة');
            $t->decimal('total', 15, 2)->default(0)->comment('بعد الخصم والضريبة');

            // ─── سبب الإرجاع ───
            $t->text('return_reason')->nullable();

            $t->timestamps();

            // ─── الفهارس ───
            $t->index(['sale_return_id', 'product_id']);
        });
    }

    /**
     * حذف الجدول عند الـrollback
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_return_items');
    }
};