<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * زرع كل المميزات من السايدبار + توزيعها على الباقات
 * 
 * الـ4 باقات:
 *   1 = الأساسيّة     (79 ر/شهر)
 *   2 = المتقدّمة     (129 ر/شهر)
 *   3 = الاحترافيّة   (159 ر/شهر)
 *   4 = الشاملة       (469 ر/شهر)
 */
class FeaturesSeeder extends Seeder
{
    public function run(): void
    {
        // ─── قائمة المميزات الكاملة ───
        $features = [
            // ═══════════════════════════════════════════════════
            // الفئة: المبيعات (Sales)
            // ═══════════════════════════════════════════════════
            ['code' => 'sales-management', 'name_ar' => 'إدارة الفواتير', 'name_en' => 'Sales Management', 'category' => 'sales', 'icon' => 'las la-file-invoice', 'route_name' => 'user.sale.list'],
            ['code' => 'sale-create', 'name_ar' => 'إنشاء فاتورة', 'name_en' => 'Create Sale', 'category' => 'sales', 'icon' => 'las la-plus-circle', 'route_name' => 'user.sale.add'],
            ['code' => 'credit-note', 'name_ar' => 'إشعارات دائنة', 'name_en' => 'Credit Notes', 'category' => 'sales', 'icon' => 'las la-receipt', 'route_name' => 'user.credit-note.list'],
            ['code' => 'sale-returns', 'name_ar' => 'الفواتير المرتجعة', 'name_en' => 'Sale Returns', 'category' => 'sales', 'icon' => 'las la-undo'],
            ['code' => 'recurring-invoices', 'name_ar' => 'الفواتير الدوريّة', 'name_en' => 'Recurring Invoices', 'category' => 'sales', 'icon' => 'las la-redo', 'is_premium' => true],
            ['code' => 'customer-payments', 'name_ar' => 'مدفوعات العملاء', 'name_en' => 'Customer Payments', 'category' => 'sales', 'icon' => 'las la-money-check'],
            ['code' => 'sales-settings', 'name_ar' => 'إعدادات المبيعات', 'name_en' => 'Sales Settings', 'category' => 'sales', 'icon' => 'las la-cog'],

            // ═══════════════════════════════════════════════════
            // الفئة: نقطة البيع (POS)
            // ═══════════════════════════════════════════════════
            ['code' => 'pos', 'name_ar' => 'نقطة البيع (الكاشير)', 'name_en' => 'Point of Sale', 'category' => 'pos', 'icon' => 'las la-cash-register', 'route_name' => 'user.pos.index'],
            ['code' => 'pos-multi-cashier', 'name_ar' => 'كاشير متعدّد', 'name_en' => 'Multi Cashier', 'category' => 'pos', 'icon' => 'las la-users', 'is_premium' => true],
            ['code' => 'pos-receipt-printer', 'name_ar' => 'طابعة الإيصالات', 'name_en' => 'Receipt Printer', 'category' => 'pos', 'icon' => 'las la-print'],
            ['code' => 'pos-barcode', 'name_ar' => 'دعم الباركود', 'name_en' => 'Barcode Support', 'category' => 'pos', 'icon' => 'las la-barcode'],

            // ═══════════════════════════════════════════════════
            // الفئة: العملاء (Customers)
            // ═══════════════════════════════════════════════════
            ['code' => 'customers', 'name_ar' => 'إدارة العملاء', 'name_en' => 'Customers', 'category' => 'customers', 'icon' => 'las la-user-friends', 'route_name' => 'user.customer.list'],
            ['code' => 'customer-credit', 'name_ar' => 'حسابات العملاء الدائنة', 'name_en' => 'Customer Credit', 'category' => 'customers', 'icon' => 'las la-coins'],
            ['code' => 'customer-groups', 'name_ar' => 'مجموعات العملاء', 'name_en' => 'Customer Groups', 'category' => 'customers', 'icon' => 'las la-users-cog', 'is_premium' => true],
            ['code' => 'loyalty-points', 'name_ar' => 'نقاط الولاء', 'name_en' => 'Loyalty Points', 'category' => 'customers', 'icon' => 'las la-star', 'is_premium' => true],

            // ═══════════════════════════════════════════════════
            // الفئة: المخزون (Inventory)
            // ═══════════════════════════════════════════════════
            ['code' => 'products', 'name_ar' => 'إدارة المنتجات', 'name_en' => 'Products', 'category' => 'inventory', 'icon' => 'las la-box', 'route_name' => 'user.product.list'],
            ['code' => 'categories', 'name_ar' => 'الفئات', 'name_en' => 'Categories', 'category' => 'inventory', 'icon' => 'las la-th-list'],
            ['code' => 'brands', 'name_ar' => 'العلامات التجاريّة', 'name_en' => 'Brands', 'category' => 'inventory', 'icon' => 'las la-tag'],
            ['code' => 'product-variants', 'name_ar' => 'متغيّرات المنتجات', 'name_en' => 'Product Variants', 'category' => 'inventory', 'icon' => 'las la-clone', 'is_premium' => true],
            ['code' => 'stock-adjustments', 'name_ar' => 'تسويات المخزون', 'name_en' => 'Stock Adjustments', 'category' => 'inventory', 'icon' => 'las la-sliders-h'],
            ['code' => 'stock-transfers', 'name_ar' => 'تحويلات المخزون', 'name_en' => 'Stock Transfers', 'category' => 'inventory', 'icon' => 'las la-exchange-alt', 'is_premium' => true],
            ['code' => 'low-stock-alerts', 'name_ar' => 'تنبيهات المخزون المنخفض', 'name_en' => 'Low Stock Alerts', 'category' => 'inventory', 'icon' => 'las la-exclamation-triangle'],
            ['code' => 'expiry-tracking', 'name_ar' => 'تتبّع تواريخ الانتهاء', 'name_en' => 'Expiry Tracking', 'category' => 'inventory', 'icon' => 'las la-calendar-times', 'is_premium' => true],

            // ═══════════════════════════════════════════════════
            // الفئة: المشتريات (Purchases)
            // ═══════════════════════════════════════════════════
            ['code' => 'purchases', 'name_ar' => 'فواتير الشراء', 'name_en' => 'Purchases', 'category' => 'purchases', 'icon' => 'las la-shopping-cart', 'route_name' => 'user.purchase.list'],
            ['code' => 'purchase-create', 'name_ar' => 'إنشاء فاتورة شراء', 'name_en' => 'Create Purchase', 'category' => 'purchases', 'icon' => 'las la-plus-square'],
            ['code' => 'purchase-returns', 'name_ar' => 'مرتجعات الشراء', 'name_en' => 'Purchase Returns', 'category' => 'purchases', 'icon' => 'las la-reply', 'is_premium' => true],
            ['code' => 'supplier-management', 'name_ar' => 'إدارة الموردين', 'name_en' => 'Supplier Management', 'category' => 'purchases', 'icon' => 'las la-truck'],

            // ═══════════════════════════════════════════════════
            // الفئة: المالية (Finance)
            // ═══════════════════════════════════════════════════
            ['code' => 'expenses', 'name_ar' => 'المصاريف', 'name_en' => 'Expenses', 'category' => 'finance', 'icon' => 'las la-money-bill-wave'],
            ['code' => 'income', 'name_ar' => 'الإيرادات', 'name_en' => 'Income', 'category' => 'finance', 'icon' => 'las la-hand-holding-usd'],
            ['code' => 'accounts', 'name_ar' => 'الحسابات البنكيّة', 'name_en' => 'Bank Accounts', 'category' => 'finance', 'icon' => 'las la-piggy-bank'],
            ['code' => 'transfers', 'name_ar' => 'التحويلات', 'name_en' => 'Transfers', 'category' => 'finance', 'icon' => 'las la-exchange-alt', 'is_premium' => true],
            ['code' => 'chart-of-accounts', 'name_ar' => 'دليل الحسابات', 'name_en' => 'Chart of Accounts', 'category' => 'finance', 'icon' => 'las la-sitemap', 'is_premium' => true],
            ['code' => 'journal-entries', 'name_ar' => 'القيود اليوميّة', 'name_en' => 'Journal Entries', 'category' => 'finance', 'icon' => 'las la-book', 'is_premium' => true],

            // ═══════════════════════════════════════════════════
            // الفئة: التقارير (Reports)
            // ═══════════════════════════════════════════════════
            ['code' => 'sales-reports', 'name_ar' => 'تقارير المبيعات', 'name_en' => 'Sales Reports', 'category' => 'reports', 'icon' => 'las la-chart-line'],
            ['code' => 'inventory-reports', 'name_ar' => 'تقارير المخزون', 'name_en' => 'Inventory Reports', 'category' => 'reports', 'icon' => 'las la-chart-bar'],
            ['code' => 'financial-reports', 'name_ar' => 'التقارير الماليّة', 'name_en' => 'Financial Reports', 'category' => 'reports', 'icon' => 'las la-chart-pie', 'is_premium' => true],
            ['code' => 'profit-loss-report', 'name_ar' => 'تقرير الربح والخسارة', 'name_en' => 'Profit & Loss', 'category' => 'reports', 'icon' => 'las la-balance-scale', 'is_premium' => true],
            ['code' => 'customer-reports', 'name_ar' => 'تقارير العملاء', 'name_en' => 'Customer Reports', 'category' => 'reports', 'icon' => 'las la-users', 'is_premium' => true],
            ['code' => 'product-reports', 'name_ar' => 'تقارير المنتجات', 'name_en' => 'Product Reports', 'category' => 'reports', 'icon' => 'las la-box-open'],
            ['code' => 'export-pdf', 'name_ar' => 'تصدير PDF', 'name_en' => 'PDF Export', 'category' => 'reports', 'icon' => 'las la-file-pdf'],
            ['code' => 'export-excel', 'name_ar' => 'تصدير Excel', 'name_en' => 'Excel Export', 'category' => 'reports', 'icon' => 'las la-file-excel', 'is_premium' => true],

            // ═══════════════════════════════════════════════════
            // الفئة: التسويق (Marketing) - WhatsApp Store
            // ═══════════════════════════════════════════════════
            ['code' => 'whatsapp-store', 'name_ar' => 'متجر واتساب', 'name_en' => 'WhatsApp Store', 'category' => 'marketing', 'icon' => 'lab la-whatsapp', 'is_premium' => true],
            ['code' => 'whatsapp-orders', 'name_ar' => 'طلبات واتساب', 'name_en' => 'WhatsApp Orders', 'category' => 'marketing', 'icon' => 'las la-comment-dots', 'is_premium' => true],
            ['code' => 'whatsapp-catalog', 'name_ar' => 'كتالوج واتساب', 'name_en' => 'WhatsApp Catalog', 'category' => 'marketing', 'icon' => 'las la-th', 'is_premium' => true],
            ['code' => 'sales-targets', 'name_ar' => 'أهداف المبيعات', 'name_en' => 'Sales Targets', 'category' => 'marketing', 'icon' => 'las la-bullseye', 'is_premium' => true],

            // ═══════════════════════════════════════════════════
            // الفئة: الموارد البشريّة (HR)
            // ═══════════════════════════════════════════════════
            ['code' => 'staff-management', 'name_ar' => 'إدارة الموظّفين', 'name_en' => 'Staff Management', 'category' => 'hr', 'icon' => 'las la-user-tie'],
            ['code' => 'roles-permissions', 'name_ar' => 'الأدوار والصلاحيّات', 'name_en' => 'Roles & Permissions', 'category' => 'hr', 'icon' => 'las la-user-shield'],
            ['code' => 'attendance', 'name_ar' => 'الحضور والانصراف', 'name_en' => 'Attendance', 'category' => 'hr', 'icon' => 'las la-fingerprint', 'is_premium' => true],
            ['code' => 'payroll', 'name_ar' => 'المرتّبات', 'name_en' => 'Payroll', 'category' => 'hr', 'icon' => 'las la-money-check-alt', 'is_premium' => true],

            // ═══════════════════════════════════════════════════
            // الفئة: الفروع (Branches)
            // ═══════════════════════════════════════════════════
            ['code' => 'multi-warehouse', 'name_ar' => 'مستودعات متعدّدة', 'name_en' => 'Multi Warehouse', 'category' => 'branches', 'icon' => 'las la-warehouse'],
            ['code' => 'multi-branch', 'name_ar' => 'فروع متعدّدة', 'name_en' => 'Multi Branch', 'category' => 'branches', 'icon' => 'las la-store-alt', 'is_premium' => true],
            ['code' => 'branch-reports', 'name_ar' => 'تقارير الفروع', 'name_en' => 'Branch Reports', 'category' => 'branches', 'icon' => 'las la-chart-pie', 'is_premium' => true],

            // ═══════════════════════════════════════════════════
            // الفئة: الإعدادات (Settings)
            // ═══════════════════════════════════════════════════
            ['code' => 'general-settings', 'name_ar' => 'الإعدادات العامّة', 'name_en' => 'General Settings', 'category' => 'settings', 'icon' => 'las la-cogs'],
            ['code' => 'tax-settings', 'name_ar' => 'إعدادات الضرائب', 'name_en' => 'Tax Settings', 'category' => 'settings', 'icon' => 'las la-percent'],
            ['code' => 'zatca-integration', 'name_ar' => 'الفاتورة الإلكترونيّة (ZATCA)', 'name_en' => 'ZATCA Integration', 'category' => 'settings', 'icon' => 'las la-file-invoice-dollar', 'is_premium' => true],
            ['code' => 'multi-currency', 'name_ar' => 'دعم عملات متعدّدة', 'name_en' => 'Multi Currency', 'category' => 'settings', 'icon' => 'las la-coins', 'is_premium' => true],
            ['code' => 'api-access', 'name_ar' => 'API للمطوّرين', 'name_en' => 'Developer API', 'category' => 'settings', 'icon' => 'las la-code', 'is_premium' => true],
            ['code' => 'custom-fields', 'name_ar' => 'حقول مخصّصة', 'name_en' => 'Custom Fields', 'category' => 'settings', 'icon' => 'las la-list-alt', 'is_premium' => true],
        ];

        // ─── إدخال المميزات ───
        $sortOrder = 0;
        foreach ($features as $feature) {
            DB::table('features')->insertOrIgnore(array_merge($feature, [
                'sort_order' => $sortOrder++,
                'is_premium' => $feature['is_premium'] ?? false,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // ─── ربط الميزات بالباقات ───
        $allFeatures = DB::table('features')->pluck('id', 'code');

        // الباقة الأساسيّة (79 ر) — أساسيّات فقط
        $basicFeatures = [
            'sales-management', 'sale-create', 'customer-payments',
            'pos', 'pos-receipt-printer', 'pos-barcode',
            'customers', 'customer-credit',
            'products', 'categories', 'brands', 'stock-adjustments', 'low-stock-alerts',
            'purchases', 'purchase-create', 'supplier-management',
            'expenses', 'income', 'accounts',
            'sales-reports', 'inventory-reports', 'product-reports', 'export-pdf',
            'staff-management', 'roles-permissions',
            'multi-warehouse', 'general-settings', 'tax-settings',
        ];

        // الباقة المتقدّمة (129 ر) = الأساسيّة + إضافات
        $advancedFeatures = array_merge($basicFeatures, [
            'credit-note', 'sale-returns', 'sales-settings',
            'customer-groups', 'pos-multi-cashier',
            'stock-transfers', 'purchase-returns',
            'transfers', 'financial-reports', 'customer-reports', 'export-excel',
            'zatca-integration',
        ]);

        // الباقة الاحترافيّة (159 ر) = المتقدّمة + إضافات
        $professionalFeatures = array_merge($advancedFeatures, [
            'recurring-invoices', 'sales-targets', 'loyalty-points',
            'product-variants', 'expiry-tracking',
            'chart-of-accounts', 'journal-entries',
            'profit-loss-report',
            'whatsapp-store', 'whatsapp-orders', 'whatsapp-catalog',
            'attendance', 'payroll',
            'multi-branch', 'branch-reports',
            'multi-currency',
        ]);

        // الباقة الشاملة (469 ر) = كل المميزات
        $enterpriseFeatures = collect($features)->pluck('code')->toArray();

        // ─── الإدخال للـpivot ───
        $planMap = [
            1 => $basicFeatures,
            2 => $advancedFeatures,
            3 => $professionalFeatures,
            4 => $enterpriseFeatures,
        ];

        foreach ($planMap as $planId => $featureCodes) {
            foreach ($featureCodes as $code) {
                if (isset($allFeatures[$code])) {
                    DB::table('plan_features')->insertOrIgnore([
                        'plan_id'    => $planId,
                        'feature_id' => $allFeatures[$code],
                        'is_enabled' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $this->command->info('✅ تمّت إضافة ' . count($features) . ' ميزة');
        $this->command->info('✅ تمّ ربط المميزات بـ4 باقات');
    }
}