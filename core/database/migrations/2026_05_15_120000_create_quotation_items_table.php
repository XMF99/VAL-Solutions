<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * إنشاء جدول quotation_items (بنود عروض الأسعار)
     */
    public function up(): void
    {
        if (Schema::hasTable('quotation_items')) {
            return; // الجدول موجود — لا نسوّي شي
        }

        Schema::create('quotation_items', function (Blueprint $t) {
            $t->id();

            // ─── الارتباطات ───
            $t->unsignedBigInteger('quotation_id')->index();
            $t->unsignedBigInteger('product_id')->nullable()->index();

            // ─── معلومات البند ───
            $t->string('product_name');
            $t->text('description')->nullable();

            // ─── الكميّات والأسعار ───
            $t->decimal('quantity', 15, 2)->default(1);
            $t->decimal('unit_price', 15, 2)->default(0);

            // ─── الخصم والضريبة (نسبة مئويّة) ───
            $t->decimal('discount', 8, 2)->default(0)->comment('نسبة مئويّة %');
            $t->decimal('tax_rate', 8, 2)->default(0)->comment('نسبة الضريبة %');

            // ─── المجاميع المحسوبة ───
            $t->decimal('subtotal', 15, 2)->default(0)->comment('قبل الخصم والضريبة');
            $t->decimal('total', 15, 2)->default(0)->comment('بعد الخصم والضريبة');

            // ─── ترتيب البنود في الفاتورة ───
            $t->integer('sort_order')->default(0);

            $t->timestamps();

            // ─── الفهارس ───
            $t->index(['quotation_id', 'sort_order']);
        });
    }

    /**
     * حذف الجدول عند الـrollback
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};