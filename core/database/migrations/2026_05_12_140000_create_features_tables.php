<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->unique();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('category', 100)->index();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('icon', 50)->nullable()->default('las la-puzzle-piece');
            $table->string('route_name')->nullable();
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->boolean('is_premium')->default(false);
            $table->timestamps();
        });

        Schema::create('plan_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('feature_id');
            $table->boolean('is_enabled')->default(true);
            $table->integer('limit_value')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->foreign('plan_id')->references('id')->on('subscription_plans')->onDelete('cascade');
            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
            $table->unique(['plan_id', 'feature_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_features');
        Schema::dropIfExists('features');
    }
};
