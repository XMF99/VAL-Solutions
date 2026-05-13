<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * نظام الميزات (Features Layer)
     * 
     * المفهوم:
     *   features         = قائمة كل المميزات الممكنة في النظام
     *   plan_features    = أيّ ميزة متاحة لأيّ باقة (matrix)
     */
    public function up(): void
    {
        // ─── جدول المميزات الكاملة ───
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->unique()->comment('المعرّف الفريد: credit-note, pos, whatsapp-store');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('category', 100)->index()->comment('sales, inventory, finance, reports, marketing, settings');
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('icon', 50)->nullable()->default('las la-puzzle-piece');
            $table->string('route_name')->nullable()->comment('user.credit-note.list');
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('status')->default(1)->comment('1=active, 0=disabled');
            $table->boolean('is_premium')->default(false)->comment('ميزة مدفوعة احترافيّة');
            $table->timestamps();
            
            $table->index('category');
            $table->index('status');
        });

        // ─── جدول ربط الميزات بالباقات ───
        Schema::create('plan_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('feature_id');
            $table->boolean('is_enabled')->default(true);
            $table->integer('limit_value')->nullable()->comment('مثال: 5 موظفين، -1 = unlimited');
            $table->json('settings')->nullable()->comment('إعدادات إضافيّة لكل باقة');
            $table->timestamps();
            
            $table->foreign('plan_id')->references('id')->on('subscription_plans')->onDelete('cascade');
            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
            $table->unique(['plan_id', 'feature_id']);
            
            $table->index('plan_id');
            $table->index('feature_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_features');
        Schema::dropIfExists('features');
    }
};
