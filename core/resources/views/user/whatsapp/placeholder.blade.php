<?php

use Illuminate\Support\Facades\Route;

$placeholder = function ($routeName, $displayName) {
    Route::get('_ph/' . str_replace('.', '-', $routeName), function () use ($displayName) {
        return view('Template::user.placeholder', [
            'pageTitle' => $displayName,
            'name'      => $displayName,
        ]);
    })->name($routeName);
};

// SALES
$placeholder('quotation.list', 'عروض الأسعار');
$placeholder('installment.list', 'الأقساط');
$placeholder('offer.list', 'العروض والخصومات');
$placeholder('sale.return.list', 'مرتجعات المبيعات');
$placeholder('credit-note.list', 'الإشعارات الدائنة');
$placeholder('recurring-invoice.list', 'الفواتير الدوريّة');
$placeholder('customer.payments', 'مدفوعات العملاء');

// POS
$placeholder('cash_register.sessions', 'جلسات الصندوق');
$placeholder('pos.receipts', 'إيصالات نقاط البيع');

// TARGETS
$placeholder('target.list', 'أهداف المبيعات');
$placeholder('commission.list', 'العمولات');
$placeholder('commission.performance', 'تقارير الأداء');

// CRM
$placeholder('customer.groups', 'مجموعات العملاء');
$placeholder('appointment.list', 'المواعيد');
$placeholder('customer.visits', 'حضور العملاء');
$placeholder('membership.list', 'العضويّات والاشتراكات');
$placeholder('customer.insurance', 'تأمينات العملاء');

// BALANCES
$placeholder('balance.list', 'أرصدة العملاء');
$placeholder('balance.transactions', 'حركة الأرصدة');
$placeholder('balance.settlements', 'التسويات');

// LOYALTY
$placeholder('loyalty.settings', 'إعدادات نقاط الولاء');
$placeholder('loyalty.transactions', 'حركة نقاط الولاء');
$placeholder('loyalty.reports', 'تقارير الولاء');

// INVENTORY
$placeholder('stock-adjustment.list', 'تسويات المخزون / الجرد');
$placeholder('stock-transfer.list', 'تحويل المخزون');
$placeholder('stock-permit.list', 'الأذون المخزنيّة');
$placeholder('price-list.list', 'قوائم الأسعار');
$placeholder('product.barcode', 'طباعة الباركود');

// PURCHASES
$placeholder('purchase-order.list', 'أوامر الشراء');
$placeholder('purchase.return.list', 'مرتجعات الشراء');

// FINANCE
$placeholder('income.list', 'الإيرادات');
$placeholder('account.list', 'الحسابات البنكيّة');
$placeholder('transfer.list', 'تحويلات الأموال');
$placeholder('check.list', 'الشيكات');

// ACCOUNTING
$placeholder('coa.index', 'دليل الحسابات');
$placeholder('journal.list', 'القيود اليوميّة');
$placeholder('ledger.index', 'دفتر الأستاذ');
$placeholder('cost-center.list', 'مراكز التكلفة');
$placeholder('asset.list', 'الأصول الثابتة');
$placeholder('financial-report.index', 'التقارير الماليّة');

// OPERATIONS
$placeholder('work-order.list', 'أوامر الشغل');
$placeholder('project.list', 'المشاريع');
$placeholder('workflow.list', 'دورات العمل');
$placeholder('timesheet.list', 'تتبّع الوقت');
$placeholder('rental.list', 'وحدات الإيجار');
$placeholder('lease.list', 'عقود الإيجار');
$placeholder('reservation.list', 'الحجوزات');
$placeholder('manufacturing.list', 'التصنيع');

// HR
$placeholder('employee.list', 'الموظّفين');
$placeholder('attendance.list', 'الحضور والانصراف');
$placeholder('payroll.list', 'المرتّبات');
$placeholder('contract.list', 'العقود');
$placeholder('org-structure.index', 'الهيكل التنظيمي');
$placeholder('leave.list', 'الإجازات');
$placeholder('hr-request.list', 'طلبات الموظّفين');
$placeholder('advance.list', 'السلف والقروض');

// REPORTS
$placeholder('report.sales', 'تقارير المبيعات');
$placeholder('report.inventory', 'تقارير المخزون');
$placeholder('report.accounting', 'تقارير محاسبيّة');
$placeholder('report.employees', 'تقارير الموظّفين');
$placeholder('report.customers', 'تقارير العملاء');
$placeholder('report.performance', 'تقارير الأداء');

// BRANCHES
$placeholder('branch.list', 'إدارة الفروع');
$placeholder('branch.permissions', 'صلاحيّات الفروع');
$placeholder('branch.reports', 'تقارير الفروع');

// SETTINGS
$placeholder('tax.list', 'إعدادات الضرائب');
$placeholder('setting.zatca', 'الفاتورة الإلكترونيّة');
$placeholder('currency.list', 'العملات');
$placeholder('template.list', 'قوالب الطباعة');
$placeholder('role.list', 'الأدوار والصلاحيّات');
$placeholder('setting.notifications', 'إعدادات الإشعارات');
$placeholder('setting.api', 'الـAPI والتكاملات');
forge@ITE:~/vallsolutions.com/current/core$ cd ~/vallsolutions.com/current/core
forge@ITE:~/vallsolutions.com/current/core$ cat resources/views/templates/basic/user/placeholder.blade.php
@extends($activeTemplate . 'layouts.master')

@push('style')
<style>
    .ph-container { min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px; font-family: 'Cairo', 'Tajawal', sans-serif; direction: rtl; }
    .ph-card { background: white; border-radius: 24px; padding: 50px 40px; text-align: center; max-width: 540px; width: 100%; border: 1px solid #E2E8F0; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04); position: relative; overflow: hidden; }
    .ph-card::before { content: ''; position: absolute; top: -100px; left: -100px; width: 280px; height: 280px; background: radial-gradient(circle, rgba(79, 70, 229, 0.08), transparent 70%); pointer-events: none; }
    .ph-card::after { content: ''; position: absolute; bottom: -100px; right: -100px; width: 280px; height: 280px; background: radial-gradient(circle, rgba(236, 72, 153, 0.06), transparent 70%); pointer-events: none; }
    .ph-icon { width: 88px; height: 88px; margin: 0 auto 24px; background: linear-gradient(135deg, #4F46E5, #7C3AED); border-radius: 22px; display: flex; align-items: center; justify-content: center; color: white; font-size: 40px; box-shadow: 0 12px 24px rgba(79, 70, 229, 0.3); position: relative; z-index: 1; animation: ph-float 3s ease-in-out infinite; }
    @keyframes ph-float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
    .ph-title { font-size: 24px; font-weight: 900; color: #0F172A; margin: 0 0 10px; position: relative; z-index: 1; }
    .ph-subtitle { font-size: 14px; color: #64748B; margin: 0 0 8px; position: relative; z-index: 1; }
    .ph-name { display: inline-block; background: #EEF2FF; color: #4F46E5; padding: 6px 16px; border-radius: 10px; font-size: 13px; font-weight: 800; margin-top: 14px; position: relative; z-index: 1; }
    .ph-progress { margin: 30px auto 0; height: 6px; background: #F1F5F9; border-radius: 3px; overflow: hidden; max-width: 280px; position: relative; z-index: 1; }
    .ph-progress-bar { height: 100%; background: linear-gradient(90deg, #4F46E5, #7C3AED, #EC4899); background-size: 200% 100%; animation: ph-shimmer 2s linear infinite; width: 35%; border-radius: 3px; }
    @keyframes ph-shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    .ph-back { display: inline-flex; align-items: center; gap: 6px; margin-top: 24px; padding: 10px 20px; background: #F1F5F9; color: #475569; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; transition: all 0.2s; position: relative; z-index: 1; }
    .ph-back:hover { background: #E2E8F0; color: #0F172A; }
</style>
@endpush

@section('panel')
<div class="ph-container">
    <div class="ph-card">
        <div class="ph-icon"><i class="las la-tools"></i></div>
        <h2 class="ph-title">قيد التطوير</h2>
        <p class="ph-subtitle">هذه الميزة على وشك الإطلاق — قريباً جداً!</p>
        <div class="ph-name"><i class="las la-bookmark"></i> {{ $name ?? 'صفحة' }}</div>
        <div class="ph-progress"><div class="ph-progress-bar"></div></div>
        <a href="{{ route('user.home') }}" class="ph-back"><i class="las la-arrow-right"></i> الرجوع للوحة التحكم</a>
    </div>
</div>
@endsection
