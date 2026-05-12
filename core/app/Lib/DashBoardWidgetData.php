<?php

namespace App\Lib;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WhatsappOrder;
use App\Models\ProductStock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * ═══════════════════════════════════════════════════════════
 * Val POS — Dashboard Widget Data Provider
 * ═══════════════════════════════════════════════════════════
 * 
 * هذا الـclass يحضّر كل بيانات لوحة التحكّم للتاجر
 * 
 * طريقة الاستخدام (في UserController@home):
 *   $widget = DashBoardWidgetData::getWidgetData();
 * 
 * كل method يضيف keys للـ$widget التي ترجع
 * ────────────────────────────────────────────────────────────
 */
class DashBoardWidgetData
{
    /**
     * يجمع كل بيانات الـwidget من كل الـmethods
     * (يبقى كما هو — هذا الـcontract الأصلي مع UserController)
     */
    public static function getWidgetData(): array
    {
        $widget = [];

        foreach (get_class_methods(self::class) as $methodName) {
            // skip the orchestrator + helper methods
            if (in_array($methodName, [
                'getWidgetData',
                'getEnrichedData',
                'getChartData',
                'getSmartAlerts',
                'getInitials'
            ])) {
                continue;
            }

            $widget = array_merge($widget, self::$methodName());
        }

        return $widget;
    }

    // ═══════════════════════════════════════════════════════════
    // ═══════ METHODS الموجودة أصلاً (لا تُمسّ — نفسها)
    // ═══════════════════════════════════════════════════════════

    public static function salesWidgetData(): array
    {
        $user = getParentUser();

        return Sale::where('user_id', $user->id)->selectRaw("
            COALESCE(SUM(CASE WHEN sale_date = ? THEN total END), 0) as today_sale,
            COALESCE(SUM(CASE WHEN sale_date = ? THEN total END), 0) as yesterday_sale,
            COALESCE(SUM(CASE WHEN sale_date >= ? THEN total END), 0) as this_week_sale,
            COALESCE(SUM(CASE WHEN sale_date >= ? THEN total END), 0) as this_month_sale,
            COALESCE(SUM(total), 0) as all_sale
        ", [
            now()->format("Y-m-d"),
            now()->subDay()->format("Y-m-d"),
            now()->startOfWeek()->format("Y-m-d"),
            now()->startOfMonth()->format("Y-m-d"),
        ])->first()->toArray();
    }

    public static function purchaseWidgetData(): array
    {
        $user = getParentUser();

        return Purchase::where('user_id', $user->id)->selectRaw("
            COALESCE(SUM(CASE WHEN purchase_date = ? THEN total END), 0) as today_purchase,
            COALESCE(SUM(CASE WHEN purchase_date >= ? THEN total END), 0) as this_week_purchase,
            COALESCE(SUM(CASE WHEN purchase_date >= ? THEN total END), 0) as this_month_purchase,
            COALESCE(SUM(total), 0) as all_purchase
        ", [
            now()->format("Y-m-d"),
            now()->startOfWeek()->format("Y-m-d"),
            now()->startOfMonth()->format("Y-m-d"),
        ])->first()->toArray();
    }

    public static function expenseWidgetData(): array
    {
        $user = getParentUser();

        return Expense::where('user_id', $user->id)->selectRaw("
            COALESCE(SUM(CASE WHEN expense_date = ? THEN amount END), 0) as today_expense,
            COALESCE(SUM(CASE WHEN expense_date >= ? THEN amount END), 0) as this_week_expense,
            COALESCE(SUM(CASE WHEN expense_date >= ? THEN amount END), 0) as this_month_expense,
            COALESCE(SUM(amount), 0) as all_expense
        ", [
            now()->format("Y-m-d"),
            now()->startOfWeek()->format("Y-m-d"),
            now()->startOfMonth()->format("Y-m-d"),
        ])->first()->toArray();
    }

    public static function userWidgetData(): array
    {
        return User::selectRaw("
            COUNT(*) as total_users,
            COUNT(CASE WHEN status = 1 THEN 1 END) as active_users,
            COUNT(CASE WHEN ev = 0 THEN 1 END) as email_unverified_users,
            COUNT(CASE WHEN sv = 0 THEN 1 END) as mobile_unverified_users
        ")->first()->toArray();
    }

    // ═══════════════════════════════════════════════════════════
    // ═══════ METHODS جديدة — تربط البيانات الفعليّة بـview
    // ═══════════════════════════════════════════════════════════

    /**
     * عدد الطلبات + بيانات إضافيّة عن المبيعات
     * يضيف: today_orders_count, week_orders_count, month_orders_count, avg_order_value
     */
    public static function ordersCountData(): array
    {
        $user = getParentUser();

        return Sale::where('user_id', $user->id)->selectRaw("
            COUNT(CASE WHEN sale_date = ? THEN 1 END) as today_orders_count,
            COUNT(CASE WHEN sale_date >= ? THEN 1 END) as week_orders_count,
            COUNT(CASE WHEN sale_date >= ? THEN 1 END) as month_orders_count,
            COALESCE(AVG(CASE WHEN sale_date = ? THEN total END), 0) as today_avg_order
        ", [
            now()->format("Y-m-d"),
            now()->startOfWeek()->format("Y-m-d"),
            now()->startOfMonth()->format("Y-m-d"),
            now()->format("Y-m-d"),
        ])->first()->toArray();
    }

    /**
     * بيانات العملاء — الحالي + الجدد
     * يضيف: total_customers, active_customers, new_customers_month
     */
    public static function customersData(): array
    {
        $user = getParentUser();
        $monthStart = now()->startOfMonth()->format('Y-m-d');
        $thirtyDaysAgo = now()->subDays(30)->format('Y-m-d');

        $total = Customer::where('user_id', $user->id)->count();
        $newThisMonth = Customer::where('user_id', $user->id)
            ->where('created_at', '>=', $monthStart)
            ->count();

        // عملاء نشطون = عندهم طلب في آخر 30 يوم
        $active = Sale::where('user_id', $user->id)
            ->where('sale_date', '>=', $thirtyDaysAgo)
            ->distinct('customer_id')
            ->count('customer_id');

        return [
            'total_customers'       => $total,
            'active_customers'      => $active,
            'new_customers_month'   => $newThisMonth,
        ];
    }

    /**
     * بيانات الواتس اب — إن وُجد
     * يضيف: whatsapp_orders_today, whatsapp_orders_month, whatsapp_revenue_month
     */
    public static function whatsappData(): array
    {
        $user = getParentUser();

        // إذا الـmodel غير موجود أو لم يفعّل واتساب، نرجع 0
        if (!class_exists(\App\Models\WhatsappOrder::class)) {
            return [
                'whatsapp_orders_today'   => 0,
                'whatsapp_orders_month'   => 0,
                'whatsapp_revenue_month'  => 0,
            ];
        }

        $monthStart = now()->startOfMonth()->format('Y-m-d');
        $today = now()->format('Y-m-d');

        $todayCount = WhatsappOrder::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->count();

        $monthCount = WhatsappOrder::where('user_id', $user->id)
            ->where('created_at', '>=', $monthStart)
            ->count();

        $monthRevenue = WhatsappOrder::where('user_id', $user->id)
            ->where('created_at', '>=', $monthStart)
            ->sum('total') ?? 0;

        return [
            'whatsapp_orders_today'   => $todayCount,
            'whatsapp_orders_month'   => $monthCount,
            'whatsapp_revenue_month'  => $monthRevenue,
        ];
    }

    /**
     * عدد الفروع/المستودعات والموظّفين
     */
    public static function branchesData(): array
    {
        $user = getParentUser();

        $warehousesCount = Warehouse::where('user_id', $user->id)->count();
        $staffCount = User::where('parent_user_id', $user->id)
            ->orWhere('id', $user->id)
            ->count();

        return [
            'branches_count'  => $warehousesCount,
            'staff_count'     => $staffCount,
        ];
    }

    /**
     * المنتجات قاربت على النفاد
     * يضيف: low_stock_count
     */
    public static function inventoryData(): array
    {
        $user = getParentUser();
        $threshold = 5; // عدّل حسب الحاجة

        $lowStockCount = 0;

        try {
            $lowStockCount = ProductStock::whereHas('product', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
                ->where('stock', '<=', $threshold)
                ->where('stock', '>', 0)
                ->count();
        } catch (\Exception $e) {
            // في حال عدم وجود علاقة product
        }

        return [
            'low_stock_count' => $lowStockCount,
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // ═══════ Helper Methods (لا تُضاف للـwidget الأساسي)
    // ═══════════════════════════════════════════════════════════

    /**
     * بيانات الـchart الأسبوعيّة — آخر 7 أيّام
     * تُستدعى مباشرة من Controller (مو ضمن getWidgetData)
     */
    public static function getChartData(): array
    {
        $user = getParentUser();

        $weekly = [
            'labels'   => [],
            'sales'    => [],
            'expenses' => [],
            'profit'   => [],
            'orders'   => [],
        ];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateStr = $date->format('Y-m-d');

            $weekly['labels'][] = $date->locale('ar')->isoFormat('ddd');

            $daySales = Sale::where('user_id', $user->id)
                ->whereDate('sale_date', $dateStr)
                ->sum('total');

            $dayExpenses = Expense::where('user_id', $user->id)
                ->whereDate('expense_date', $dateStr)
                ->sum('amount');

            $dayOrders = Sale::where('user_id', $user->id)
                ->whereDate('sale_date', $dateStr)
                ->count();

            $weekly['sales'][]    = (float) $daySales;
            $weekly['expenses'][] = (float) $dayExpenses;
            $weekly['profit'][]   = (float) ($daySales - $dayExpenses);
            $weekly['orders'][]   = $dayOrders;
        }

        // توزيع طرق الدفع لآخر 30 يوم
        $paymentMethods = Sale::where('user_id', $user->id)
            ->where('sale_date', '>=', now()->subDays(30)->format('Y-m-d'))
            ->join('sale_payments', 'sales.id', '=', 'sale_payments.sale_id')
            ->join('payment_types', 'sale_payments.payment_type_id', '=', 'payment_types.id')
            ->groupBy('payment_types.id', 'payment_types.name')
            ->select(
                'payment_types.name',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(sale_payments.amount) as total')
            )
            ->get()
            ->map(fn($p) => [
                'name'  => $p->name,
                'count' => $p->count,
                'total' => (float) $p->total,
            ])
            ->toArray();

        // توزيع أنواع الطلبات — POS مقابل واتساب
        $todayPosOrders = Sale::where('user_id', $user->id)
            ->whereDate('sale_date', now()->format('Y-m-d'))
            ->count();

        $todayWaOrders = 0;
        if (class_exists(\App\Models\WhatsappOrder::class)) {
            $todayWaOrders = WhatsappOrder::where('user_id', $user->id)
                ->whereDate('created_at', now()->format('Y-m-d'))
                ->count();
        }

        return [
            'weekly'         => $weekly,
            'paymentMethods' => $paymentMethods,
            'orderTypes'     => [
                'pos'      => $todayPosOrders,
                'whatsapp' => $todayWaOrders,
            ],
        ];
    }

    /**
     * التنبيهات الذكيّة — Phase 2
     * تُستدعى مباشرة من Controller (مو ضمن getWidgetData)
     */
    public static function getSmartAlerts(array $widget, array $chartData): array
    {
        $alerts = [];

        // 1. تنبيه: مخزون قارب على النفاد
        if (($widget['low_stock_count'] ?? 0) > 0) {
            $count = $widget['low_stock_count'];
            $alerts[] = [
                'type'      => 'warning',
                'icon'      => 'la-exclamation-triangle',
                'title_ar'  => 'مخزون قارب على النفاد',
                'title_en'  => 'Low stock alert',
                'message_ar'=> "{$count} منتجات بحاجة لإعادة الطلب",
                'message_en'=> "{$count} products need restocking",
                'link'      => '#',
            ];
        }

        // 2. تنبيه: مبيعات اليوم تفوق المتوسّط
        $todaySale = (float) ($widget['today_sale'] ?? 0);
        $weeklySales = $chartData['weekly']['sales'] ?? [];

        if (count($weeklySales) > 1) {
            // متوسّط آخر 6 أيّام (بدون اليوم)
            $previousDays = array_slice($weeklySales, 0, -1);
            $avg = array_sum($previousDays) / max(count($previousDays), 1);

            if ($avg > 0 && $todaySale > $avg * 1.15) {
                $growth = round((($todaySale - $avg) / $avg) * 100);
                $alerts[] = [
                    'type'      => 'success',
                    'icon'      => 'la-arrow-up',
                    'title_ar'  => 'تنبيه نموّ',
                    'title_en'  => 'Growth alert',
                    'message_ar'=> "مبيعات اليوم تجاوزت متوسّط الأسبوع بنسبة {$growth}٪",
                    'message_en'=> "Today's sales exceed weekly average by {$growth}%",
                    'link'      => null,
                ];
            }
        }

        // 3. تنبيه: طلبات معلّقة من واتساب
        $pendingWa = 0;
        if (class_exists(\App\Models\WhatsappOrder::class)) {
            try {
                $pendingWa = WhatsappOrder::where('user_id', getParentUser()->id)
                    ->where('status', 0) // pending
                    ->count();
            } catch (\Exception $e) {}
        }

        if ($pendingWa > 0) {
            $alerts[] = [
                'type'      => 'info',
                'icon'      => 'la-whatsapp',
                'title_ar'  => 'طلبات واتساب جديدة',
                'title_en'  => 'New WhatsApp orders',
                'message_ar'=> "{$pendingWa} طلب جديد في انتظار التأكيد",
                'message_en'=> "{$pendingWa} orders awaiting confirmation",
                'link'      => '#',
            ];
        }

        // 4. توقّع نموّ الشهر (بسيط)
        $weeklyAvg = count($weeklySales) > 0 ? array_sum($weeklySales) / count($weeklySales) : 0;
        if ($weeklyAvg > 0) {
            $monthForecast = round($weeklyAvg * 30);
            $alerts[] = [
                'type'      => 'info',
                'icon'      => 'la-chart-line',
                'title_ar'  => 'توقّع إيرادات الشهر',
                'title_en'  => 'Monthly forecast',
                'message_ar'=> "متوقّع: " . number_format($monthForecast) . " ر.س",
                'message_en'=> "Forecast: " . number_format($monthForecast) . " SAR",
                'link'      => null,
            ];
        }

        return $alerts;
    }
}
