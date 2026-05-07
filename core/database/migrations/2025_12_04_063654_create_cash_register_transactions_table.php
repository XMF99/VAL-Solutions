<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cash_register_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cash_register_id')->default(0);
            $table->decimal('amount', 28, 8)->default(0);
            $table->tinyInteger('trx_type')->nullable()->comment("1=ale, 9=Expense");
            $table->text('details')->nullable();
            $table->unsignedInteger('payment_type_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_register_transactions');
    }
};
