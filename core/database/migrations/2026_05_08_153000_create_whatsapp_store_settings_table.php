<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * WhatsApp Store Module - Migration 1/5
 * 
 * جدول إعدادات متجر الواتساب لكل تاجر (Company)
 * يحفظ بيانات ربط Meta Cloud API + إعدادات المتجر
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_store_settings', function (Blueprint $table) {
            $table->id();
            
            // ربط بالتاجر
            $table->unsignedBigInteger('company_id');
            
            // معلومات المتجر
            $table->string('store_slug')->unique()->comment('للرابط العام: /store/{slug}');
            $table->string('store_name');
            $table->text('store_description')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('cover_url')->nullable();
            $table->string('theme_color', 20)->default('#10b981');
            
            // ربط Meta Cloud API
            $table->string('whatsapp_number', 20)->nullable()->comment('966501234567');
            $table->string('whatsapp_display_name')->nullable();
            $table->string('whatsapp_phone_id')->nullable()->comment('Phone Number ID من Meta');
            $table->string('whatsapp_business_id')->nullable()->comment('WhatsApp Business Account ID');
            $table->text('access_token')->nullable()->comment('مشفّر — Permanent Token');
            $table->string('catalog_id')->nullable()->comment('Meta Catalog ID');
            $table->string('webhook_verify_token', 64)->nullable()->comment('للتحقق من Meta');
            
            // رسائل آليّة
            $table->text('welcome_message')->nullable();
            $table->text('away_message')->nullable();
            $table->text('order_confirmation_message')->nullable();
            
            // ساعات العمل
            $table->json('business_hours')->nullable()->comment('JSON: {sun: {open: "08:00", close: "23:00"}, ...}');
            $table->boolean('is_open_now')->default(true);
            
            // إعدادات الطلب
            $table->decimal('min_order_amount', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->json('delivery_areas')->nullable()->comment('مناطق التوصيل');
            
            // طرق الدفع المفعّلة
            $table->boolean('accepts_cash')->default(true);
            $table->boolean('accepts_apple_pay')->default(false);
            $table->boolean('accepts_google_pay')->default(false);
            $table->boolean('accepts_mada')->default(false);
            $table->boolean('accepts_visa')->default(false);
            $table->boolean('accepts_bank_transfer')->default(false);
            
            // ربط Moyasar (للدفع الإلكتروني)
            $table->text('moyasar_publishable_key')->nullable();
            $table->text('moyasar_secret_key')->nullable()->comment('مشفّر');
            $table->string('moyasar_status', 20)->default('disconnected')->comment('disconnected/pending/connected');
            
            // الحالة
            $table->boolean('is_active')->default(false);
            $table->boolean('is_verified')->default(false)->comment('Meta verified the number');
            $table->timestamp('connected_at')->nullable();
            $table->timestamp('last_message_at')->nullable();
            
            // إحصائيّات سريعة (يحدّثها Job)
            $table->integer('total_orders')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->integer('total_customers')->default(0);
            
            $table->timestamps();
            
            // العلاقات والفهارس
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');
            
            $table->index('whatsapp_number');
            $table->index('whatsapp_phone_id');
            $table->index(['company_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_store_settings');
    }
};
