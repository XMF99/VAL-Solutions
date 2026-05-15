<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * إنشاء جدول installment_payments (الدفعات الفردية)
     */
    public function up(): void
    {
        if (Schema::hasTable('installment_payments')) {
            return; // الجدول موجود — لا نسوّي شي
        }

        Schema::create('installment_payments', function (Blueprint $t) {
            $t->id();

            // ─── الارتباطات ───
            $t->unsignedBigInteger('installment_plan_id')->index();

            // ─── معلومات الدفعة ───
            $t->integer('payment_number')->comment('رقم القسط (1، 2، 3...)');
            $t->decimal('amount', 15, 2)->comment('مبلغ القسط');

            // ─── التواريخ ───
            $t->date('due_date')->comment('تاريخ الاستحقاق');
            $t->date('paid_date')->nullable()->comment('تاريخ الدفع الفعلي');

            // ─── الحالة ───
            $t->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])
              ->default('pending')
              ->comment('pending=معلّقة، paid=مدفوعة، overdue=متأخرة، cancelled=ملغاة');

            // ─── طريقة الدفع ───
            $t->string('payment_method')->nullable()->comment('نقدي، بطاقة، تحويل، إلخ');

            // ─── ملاحظات ───
            $t->text('notes')->nullable();

            $t->timestamps();

            // ─── الفهارس ───
            $t->index(['installment_plan_id', 'payment_number']);
            $t->index(['status', 'due_date']);
        });
    }

    /**
     * حذف الجدول عند الـrollback
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_payments');
    }
};