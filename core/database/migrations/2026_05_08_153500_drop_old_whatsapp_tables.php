<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: حذف جداول WhatsApp القديمة
 * 
 * السبب:
 * أُنشئت بـ company_id (تشير لجدول companies الخاصّ بـ HRM)
 * بينما الصحيح هو user_id (يشير لجدول users — التاجر الفعلي)
 * 
 * هذا آمن 100% لأنّ الجداول فارغة (للتوّ أُنشئت).
 */
return new class extends Migration
{
    public function up(): void
    {
        // الترتيب مهمّ: نحذف الأبناء قبل الآباء (بسبب Foreign Keys)
        Schema::dropIfExists('whatsapp_messages');
        Schema::dropIfExists('whatsapp_orders');
        Schema::dropIfExists('whatsapp_published_products');
        Schema::dropIfExists('whatsapp_customers');
        Schema::dropIfExists('whatsapp_store_settings');
    }

    public function down(): void
    {
        // لا حاجة لـ rollback — الـ migrations الجديدة هي البديل
    }
};
