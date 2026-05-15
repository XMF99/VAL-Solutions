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