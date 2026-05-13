<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeaturesSeeder extends Seeder
{
<<<<<<< HEAD
    /**
     * زرع كل المميزات من السايدبار + توزيعها على الباقات
     * 
     * الـ4 باقات:
     *   1 = الأساسيّة     (79 ر/شهر)
     *   2 = المتقدّمة     (129 ر/شهر)
     *   3 = الاحترافيّة   (159 ر/شهر)
     *   4 = الشاملة       (469 ر/شهر)
     */
    public function run(): void
    {
        // ─── قائمة المميزات الكاملة ───
        $features = [
            // ═══════════════════════════════════════════════════
            // الفئة: المبيعات (Sales) — 7 مميزات
            // ═══════════════════════════════════════════════════
=======
    public function run(): void
    {
        $features = [
            // المبيعات
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
            ['code' => 'sales-management', 'name_ar' => 'إدارة الفواتير', 'name_en' => 'Sales Management', 'category' => 'sales', 'icon' => 'las la-file-invoice', 'route_name' => 'user.sale.list'],
            ['code' => 'sale-create', 'name_ar' => 'إنشاء فاتورة', 'name_en' => 'Create Sale', 'category' => 'sales', 'icon' => 'las la-plus-circle', 'route_name' => 'user.sale.add'],
            ['code' => 'credit-note', 'name_ar' => 'إشعارات دائنة', 'name_en' => 'Credit Notes', 'category' => 'sales', 'icon' => 'las la-receipt', 'route_name' => 'user.credit-note.list'],
            ['code' => 'sale-returns', 'name_ar' => 'الفواتير المرتجعة', 'name_en' => 'Sale Returns', 'category' => 'sales', 'icon' => 'las la-undo'],
            ['code' => 'recurring-invoices', 'name_ar' => 'الفواتير الدوريّة', 'name_en' => 'Recurring Invoices', 'category' => 'sales', 'icon' => 'las la-redo', 'is_premium' => true],
            ['code' => 'customer-payments', 'name_ar' => 'مدفوعات العملاء', 'name_en' => 'Customer Payments', 'category' => 'sales', 'icon' => 'las la-money-check'],
            ['code' => 'sales-settings', 'name_ar' => 'إعدادات المبيعات', 'name_en' => 'Sales Settings', 'category' => 'sales', 'icon' => 'las la-cog'],
<<<<<<< HEAD

            // ═══════════════════════════════════════════════════
            // الفئة: نقطة البيع (POS) — 4 مميزات
            // ═══════════════════════════════════════════════════
            ['code' => 'pos', 'name_ar' => 'نقطة البيع (الكاشير)', 'name_en' => 'Point of Sale', 'category' => 'pos', 'icon' => 'las la-cash-register', 'route_name' => 'user.pos.index'],
            ['code' => 'pos-multi-cashier', 'name_ar' => 'كاشير متعدّد', 'name_en' => 'Multi Cashier', 'category' => 'pos', 'icon' => 'las la-users', 'is_premium' => true],
            ['code' => 'pos-receipt-printer', 'name_ar' => 'طابعة الإيصالات', 'name_en' => 'Receipt Printer', 'category' => 'pos', 'icon' => 'las la-print'],
            ['code' => 'pos-barcode', 'name_ar' => 'دعم الباركود', 'name_en' => 'Barcode Support', 'category' => 'pos', 'icon' => 'las la-barcode'],

            // ═══════════════════════════════════════════════════
            // الفئة: العملاء (Customers) — 5 مميزات
            // ═══════════════════════════════════════════════════
            ['code' => 'customers', 'name_ar' => 'إدارة العملاء', 'name_en' => 'Customers', 'category' => 'customers', 'icon' => 'las la-user-friends', 'route_name' => 'user.customer.list'],
=======
            // نقطة البيع
            ['code' => 'pos', 'name_ar' => 'نقطة البيع (الكاشير)', 'name_en' => 'Point of Sale', 'category' => 'pos', 'icon' => 'las la-cash-register'],
            ['code' => 'pos-multi-cashier', 'name_ar' => 'كاشير متعدّد', 'name_en' => 'Multi Cashier', 'category' => 'pos', 'icon' => 'las la-users', 'is_premium' => true],
            ['code' => 'pos-receipt-printer', 'name_ar' => 'طابعة الإيصالات', 'name_en' => 'Receipt Printer', 'category' => 'pos', 'icon' => 'las la-print'],
            ['code' => 'pos-barcode', 'name_ar' => 'دعم الباركود', 'name_en' => 'Barcode Support', 'category' => 'pos', 'icon' => 'las la-barcode'],
            // العملاء
            ['code' => 'customers', 'name_ar' => 'إدارة العملاء', 'name_en' => 'Customers', 'category' => 'customers', 'icon' => 'las la-user-friends'],
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
            ['code' => 'customer-credit', 'name_ar' => 'حسابات العملاء الدائنة', 'name_en' => 'Customer Credit', 'category' => 'customers', 'icon' => 'las la-coins'],
            ['code' => 'loyalty-points', 'name_ar' => 'نقاط الولاء', 'name_en' => 'Loyalty Points', 'category' => 'customers', 'icon' => 'las la-star', 'is_premium' => true],
            ['code' => 'customer-groups', 'name_ar' => 'مجموعات العملاء', 'name_en' => 'Customer Groups', 'category' => 'customers', 'icon' => 'las la-layer-group'],
            ['code' => 'sales-targets', 'name_ar' => 'المبيعات المستهدفة والعمولات', 'name_en' => 'Sales Targets', 'category' => 'customers', 'icon' => 'las la-bullseye', 'is_premium' => true],
<<<<<<< HEAD

            // ═══════════════════════════════════════════════════
            // الفئة: المخزون (Inventory) — 8 مميزات
            // ═══════════════════════════════════════════════════
=======
            // المخزون
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
            ['code' => 'products', 'name_ar' => 'المنتجات', 'name_en' => 'Products', 'category' => 'inventory', 'icon' => 'las la-box'],
            ['code' => 'categories', 'name_ar' => 'الأقسام', 'name_en' => 'Categories', 'category' => 'inventory', 'icon' => 'las la-th-large'],
            ['code' => 'brands', 'name_ar' => 'العلامات التجاريّة', 'name_en' => 'Brands', 'category' => 'inventory', 'icon' => 'las la-tags'],
            ['code' => 'stock-adjustments', 'name_ar' => 'جرد المخزون', 'name_en' => 'Stock Adjustments', 'category' => 'inventory', 'icon' => 'las la-clipboard-list'],
            ['code' => 'stock-transfers', 'name_ar' => 'تحويل بين المستودعات', 'name_en' => 'Stock Transfers', 'category' => 'inventory', 'icon' => 'las la-exchange-alt'],
            ['code' => 'low-stock-alerts', 'name_ar' => 'تنبيهات نفاد المخزون', 'name_en' => 'Low Stock Alerts', 'category' => 'inventory', 'icon' => 'las la-exclamation-triangle'],
            ['code' => 'product-variants', 'name_ar' => 'منتجات بمتغيّرات', 'name_en' => 'Product Variants', 'category' => 'inventory', 'icon' => 'las la-shapes', 'is_premium' => true],
            ['code' => 'expiry-tracking', 'name_ar' => 'تتبّع الصلاحيّة', 'name_en' => 'Expiry Tracking', 'category' => 'inventory', 'icon' => 'las la-calendar-times', 'is_premium' => true],
<<<<<<< HEAD

            // ═══════════════════════════════════════════════════
            // الفئة: المشتريات (Purchases) — 4 مميزات
            // ═══════════════════════════════════════════════════
=======
            // المشتريات
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
            ['code' => 'purchases', 'name_ar' => 'إدارة المشتريات', 'name_en' => 'Purchase Management', 'category' => 'purchases', 'icon' => 'las la-shopping-cart'],
            ['code' => 'purchase-create', 'name_ar' => 'إضافة فاتورة شراء', 'name_en' => 'Create Purchase', 'category' => 'purchases', 'icon' => 'las la-plus'],
            ['code' => 'purchase-returns', 'name_ar' => 'مرتجعات المشتريات', 'name_en' => 'Purchase Returns', 'category' => 'purchases', 'icon' => 'las la-undo'],
            ['code' => 'supplier-management', 'name_ar' => 'إدارة الموردين', 'name_en' => 'Supplier Management', 'category' => 'purchases', 'icon' => 'las la-truck-loading'],
<<<<<<< HEAD

            // ═══════════════════════════════════════════════════
            // الفئة: المالية والمحاسبة (Finance) — 6 مميزات
            // ═══════════════════════════════════════════════════
=======
            // المالية
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
            ['code' => 'expenses', 'name_ar' => 'المصاريف', 'name_en' => 'Expenses', 'category' => 'finance', 'icon' => 'las la-receipt'],
            ['code' => 'income', 'name_ar' => 'الإيرادات', 'name_en' => 'Income', 'category' => 'finance', 'icon' => 'las la-coins'],
            ['code' => 'accounts', 'name_ar' => 'الحسابات', 'name_en' => 'Accounts', 'category' => 'finance', 'icon' => 'las la-wallet'],
            ['code' => 'transfers', 'name_ar' => 'التحويلات', 'name_en' => 'Transfers', 'category' => 'finance', 'icon' => 'las la-exchange-alt'],
            ['code' => 'chart-of-accounts', 'name_ar' => 'دليل الحسابات', 'name_en' => 'Chart of Accounts', 'category' => 'finance', 'icon' => 'las la-sitemap', 'is_premium' => true],
            ['code' => 'journal-entries', 'name_ar' => 'القيود اليوميّة', 'name_en' => 'Journal Entries', 'category' => 'finance', 'icon' => 'las la-book', 'is_premium' => true],
<<<<<<< HEAD

            // ═══════════════════════════════════════════════════
            // الفئة: التقارير (Reports) — 8 مميزات
            // ═══════════════════════════════════════════════════
=======
            // التقارير
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
            ['code' => 'sales-reports', 'name_ar' => 'تقارير المبيعات', 'name_en' => 'Sales Reports', 'category' => 'reports', 'icon' => 'las la-chart-line'],
            ['code' => 'inventory-reports', 'name_ar' => 'تقارير المخزون', 'name_en' => 'Inventory Reports', 'category' => 'reports', 'icon' => 'las la-warehouse'],
            ['code' => 'financial-reports', 'name_ar' => 'تقارير ماليّة', 'name_en' => 'Financial Reports', 'category' => 'reports', 'icon' => 'las la-dollar-sign'],
            ['code' => 'customer-reports', 'name_ar' => 'تقارير العملاء', 'name_en' => 'Customer Reports', 'category' => 'reports', 'icon' => 'las la-user-chart'],
            ['code' => 'product-reports', 'name_ar' => 'تقارير المنتجات', 'name_en' => 'Product Reports', 'category' => 'reports', 'icon' => 'las la-box'],
            ['code' => 'profit-loss-report', 'name_ar' => 'تقرير الأرباح والخسائر', 'name_en' => 'Profit & Loss', 'category' => 'reports', 'icon' => 'las la-balance-scale', 'is_premium' => true],
            ['code' => 'export-pdf', 'name_ar' => 'تصدير PDF', 'name_en' => 'PDF Export', 'category' => 'reports', 'icon' => 'las la-file-pdf'],
            ['code' => 'export-excel', 'name_ar' => 'تصدير Excel', 'name_en' => 'Excel Export', 'category' => 'reports', 'icon' => 'las la-file-excel'],
<<<<<<< HEAD

            // ═══════════════════════════════════════════════════
            // الفئة: WhatsApp Integration — 4 مميزات
            // ═══════════════════════════════════════════════════
=======
            // WhatsApp
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
            ['code' => 'whatsapp-store', 'name_ar' => 'متجر واتساب', 'name_en' => 'WhatsApp Store', 'category' => 'whatsapp', 'icon' => 'lab la-whatsapp', 'is_premium' => true],
            ['code' => 'whatsapp-orders', 'name_ar' => 'طلبات واتساب', 'name_en' => 'WhatsApp Orders', 'category' => 'whatsapp', 'icon' => 'lab la-whatsapp', 'is_premium' => true],
            ['code' => 'whatsapp-catalog', 'name_ar' => 'كتالوج واتساب', 'name_en' => 'WhatsApp Catalog', 'category' => 'whatsapp', 'icon' => 'las la-book', 'is_premium' => true],
            ['code' => 'whatsapp-broadcast', 'name_ar' => 'رسائل واتساب جماعيّة', 'name_en' => 'WhatsApp Broadcast', 'category' => 'whatsapp', 'icon' => 'las la-bullhorn', 'is_premium' => true],
<<<<<<< HEAD

            // ═══════════════════════════════════════════════════
            // الفئة: الموظفين والصلاحيّات (HRM) — 5 مميزات
            // ═══════════════════════════════════════════════════
=======
            // الموظفين
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
            ['code' => 'staff-management', 'name_ar' => 'إدارة الموظفين', 'name_en' => 'Staff Management', 'category' => 'hrm', 'icon' => 'las la-users-cog'],
            ['code' => 'roles-permissions', 'name_ar' => 'الأدوار والصلاحيّات', 'name_en' => 'Roles & Permissions', 'category' => 'hrm', 'icon' => 'las la-user-shield'],
            ['code' => 'attendance', 'name_ar' => 'الحضور والانصراف', 'name_en' => 'Attendance', 'category' => 'hrm', 'icon' => 'las la-clock', 'is_premium' => true],
            ['code' => 'payroll', 'name_ar' => 'الرواتب', 'name_en' => 'Payroll', 'category' => 'hrm', 'icon' => 'las la-money-bill', 'is_premium' => true],
            ['code' => 'shift-management', 'name_ar' => 'إدارة الورديّات', 'name_en' => 'Shift Management', 'category' => 'hrm', 'icon' => 'las la-business-time', 'is_premium' => true],
<<<<<<< HEAD

            // ═══════════════════════════════════════════════════
            // الفئة: الفروع والمستودعات (Branches) — 3 مميزات
            // ═══════════════════════════════════════════════════
            ['code' => 'multi-warehouse', 'name_ar' => 'مستودعات متعدّدة', 'name_en' => 'Multi Warehouse', 'category' => 'branches', 'icon' => 'las la-warehouse'],
            ['code' => 'multi-branch', 'name_ar' => 'فروع متعدّدة', 'name_en' => 'Multi Branch', 'category' => 'branches', 'icon' => 'las la-store-alt', 'is_premium' => true],
            ['code' => 'branch-reports', 'name_ar' => 'تقارير الفروع', 'name_en' => 'Branch Reports', 'category' => 'branches', 'icon' => 'las la-chart-pie', 'is_premium' => true],

            // ═══════════════════════════════════════════════════
            // الفئة: الإعدادات (Settings) — 6 مميزات
            // ═══════════════════════════════════════════════════
=======
            // الفروع
            ['code' => 'multi-warehouse', 'name_ar' => 'مستودعات متعدّدة', 'name_en' => 'Multi Warehouse', 'category' => 'branches', 'icon' => 'las la-warehouse'],
            ['code' => 'multi-branch', 'name_ar' => 'فروع متعدّدة', 'name_en' => 'Multi Branch', 'category' => 'branches', 'icon' => 'las la-store-alt', 'is_premium' => true],
            ['code' => 'branch-reports', 'name_ar' => 'تقارير الفروع', 'name_en' => 'Branch Reports', 'category' => 'branches', 'icon' => 'las la-chart-pie', 'is_premium' => true],
            // الإعدادات
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
            ['code' => 'general-settings', 'name_ar' => 'الإعدادات العامّة', 'name_en' => 'General Settings', 'category' => 'settings', 'icon' => 'las la-cogs'],
            ['code' => 'tax-settings', 'name_ar' => 'إعدادات الضرائب', 'name_en' => 'Tax Settings', 'category' => 'settings', 'icon' => 'las la-percent'],
            ['code' => 'zatca-integration', 'name_ar' => 'الفاتورة الإلكترونيّة (ZATCA)', 'name_en' => 'ZATCA Integration', 'category' => 'settings', 'icon' => 'las la-file-invoice-dollar', 'is_premium' => true],
            ['code' => 'multi-currency', 'name_ar' => 'دعم عملات متعدّدة', 'name_en' => 'Multi Currency', 'category' => 'settings', 'icon' => 'las la-coins', 'is_premium' => true],
            ['code' => 'api-access', 'name_ar' => 'API للمطوّرين', 'name_en' => 'Developer API', 'category' => 'settings', 'icon' => 'las la-code', 'is_premium' => true],
            ['code' => 'custom-fields', 'name_ar' => 'حقول مخصّصة', 'name_en' => 'Custom Fields', 'category' => 'settings', 'icon' => 'las la-list-alt', 'is_premium' => true],
        ];

<<<<<<< HEAD
        // ─── إدخال المميزات ───
=======
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
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

<<<<<<< HEAD
        // ─── ربط الميزات بالباقات ───
        // 1 = الأساسيّة | 2 = المتقدّمة | 3 = الاحترافيّة | 4 = الشاملة
        
        $allFeatures = DB::table('features')->pluck('id', 'code');

        // ميزات الباقة الأساسيّة (79 ر) — أساسيّات فقط
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
        $allFeatureCodes = array_keys($features);
        $enterpriseFeatures = collect($features)->pluck('code')->toArray();

        // ─── الإدخال للـpivot ───
=======
        $allFeatures = DB::table('features')->pluck('id', 'code');

        $basicFeatures = ['sales-management', 'sale-create', 'customer-payments', 'pos', 'pos-receipt-printer', 'pos-barcode', 'customers', 'customer-credit', 'products', 'categories', 'brands', 'stock-adjustments', 'low-stock-alerts', 'purchases', 'purchase-create', 'supplier-management', 'expenses', 'income', 'accounts', 'sales-reports', 'inventory-reports', 'product-reports', 'export-pdf', 'staff-management', 'roles-permissions', 'multi-warehouse', 'general-settings', 'tax-settings'];

        $advancedFeatures = array_merge($basicFeatures, ['credit-note', 'sale-returns', 'sales-settings', 'customer-groups', 'pos-multi-cashier', 'stock-transfers', 'purchase-returns', 'transfers', 'financial-reports', 'customer-reports', 'export-excel', 'zatca-integration']);

        $professionalFeatures = array_merge($advancedFeatures, ['recurring-invoices', 'sales-targets', 'loyalty-points', 'product-variants', 'expiry-tracking', 'chart-of-accounts', 'journal-entries', 'profit-loss-report', 'whatsapp-store', 'whatsapp-orders', 'whatsapp-catalog', 'attendance', 'payroll', 'multi-branch', 'branch-reports', 'multi-currency']);

        $enterpriseFeatures = collect($features)->pluck('code')->toArray();

>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
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
