@extends('admin.layouts.app')

@push('style')
<style>
:root {
    --vp-primary: #4F46E5;
    --vp-primary-dark: #4338CA;
    --vp-primary-light: #EEF2FF;
    --vp-primary-soft: #E0E7FF;
    --vp-text: #0F0F1A;
    --vp-text-2: #4B5563;
    --vp-text-3: #9CA3AF;
    --vp-bg: #F9FAFB;
    --vp-border: #E5E7EB;
    --vp-green: #10B981;
    --vp-blue: #3B82F6;
    --vp-amber: #F59E0B;
    --vp-red: #EF4444;
    --vp-purple: #8B5CF6;
}

.vp-admin * { box-sizing: border-box; }
.vp-admin {
    font-family: 'Cairo', 'Tajawal', system-ui, sans-serif !important;
    direction: rtl;
    padding: 0 4px;
}

/* ==== HEADER ==== */
.vp-page-header {
    background: white;
    border-radius: 18px;
    padding: 22px 26px;
    margin-bottom: 22px;
    box-shadow: 0 4px 14px rgba(79, 70, 229, 0.05);
    border: 1px solid rgba(79, 70, 229, 0.06);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}
.vp-ph-left { display: flex; align-items: center; gap: 14px; }
.vp-ph-icon {
    width: 52px;
    height: 52px;
    background: linear-gradient(135deg, var(--vp-primary) 0%, var(--vp-primary-dark) 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
}
.vp-ph-title {
    font-family: 'Cairo', sans-serif;
    font-size: 22px;
    font-weight: 900;
    color: var(--vp-text);
    margin: 0;
    line-height: 1.2;
}
.vp-ph-sub {
    font-size: 13px;
    color: var(--vp-text-3);
    margin-top: 4px;
}
.vp-ph-actions {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
}
.vp-ph-badge {
    background: var(--vp-primary-light);
    color: var(--vp-primary);
    padding: 8px 14px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* ==== STATS GRID ==== */
.vp-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 22px;
}
@media (max-width: 1024px) {
    .vp-stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
    .vp-stats-grid { grid-template-columns: 1fr; }
}

.vp-stat-card {
    background: white;
    border-radius: 18px;
    padding: 22px 20px;
    border: 1px solid var(--vp-border);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    position: relative;
    overflow: hidden;
    transition: all 0.2s;
}
.vp-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 30px rgba(79, 70, 229, 0.12);
    border-color: var(--c);
}
.vp-stat-card::before {
    content: '';
    position: absolute;
    top: 0; right: 0;
    width: 80px; height: 80px;
    background: radial-gradient(circle, var(--c-light) 0%, transparent 70%);
    opacity: 0.5;
    pointer-events: none;
}

.vp-stat-card[data-color="indigo"] { --c: #4F46E5; --c-light: #EEF2FF; --c-bg: linear-gradient(135deg, #4F46E5, #4338CA); }
.vp-stat-card[data-color="green"]  { --c: #10B981; --c-light: #ECFDF5; --c-bg: linear-gradient(135deg, #10B981, #059669); }
.vp-stat-card[data-color="blue"]   { --c: #3B82F6; --c-light: #EFF6FF; --c-bg: linear-gradient(135deg, #3B82F6, #2563EB); }
.vp-stat-card[data-color="amber"]  { --c: #F59E0B; --c-light: #FEF3C7; --c-bg: linear-gradient(135deg, #F59E0B, #D97706); }
.vp-stat-card[data-color="purple"] { --c: #8B5CF6; --c-light: #F5F3FF; --c-bg: linear-gradient(135deg, #8B5CF6, #7C3AED); }
.vp-stat-card[data-color="red"]    { --c: #EF4444; --c-light: #FEF2F2; --c-bg: linear-gradient(135deg, #EF4444, #DC2626); }

.vp-stat-icon {
    width: 48px;
    height: 48px;
    background: var(--c-bg);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: white;
    margin-bottom: 14px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    position: relative;
    z-index: 1;
}

.vp-stat-label {
    font-size: 12px;
    color: var(--vp-text-3);
    font-weight: 700;
    margin-bottom: 4px;
    letter-spacing: 0.3px;
}

.vp-stat-value {
    font-family: 'Cairo', sans-serif;
    font-size: 30px;
    font-weight: 900;
    color: var(--vp-text);
    line-height: 1;
    margin-bottom: 8px;
    letter-spacing: -1px;
}

.vp-stat-sub {
    font-size: 12px;
    color: var(--vp-text-2);
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: 600;
}
.vp-stat-sub.up { color: var(--vp-green); }
.vp-stat-sub.down { color: var(--vp-red); }

/* ==== SUBSCRIPTION REVENUE ==== */
.vp-revenue-section {
    background: white;
    border-radius: 18px;
    padding: 24px;
    margin-bottom: 22px;
    border: 1px solid var(--vp-border);
}
.vp-section-title {
    font-family: 'Cairo', sans-serif;
    font-size: 17px;
    font-weight: 900;
    color: var(--vp-text);
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.vp-revenue-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}
@media (max-width: 768px) {
    .vp-revenue-grid { grid-template-columns: repeat(2, 1fr); }
}

.vp-revenue-item {
    background: var(--vp-bg);
    border: 1px solid var(--vp-border);
    border-radius: 14px;
    padding: 18px 16px;
    transition: all 0.2s;
}
.vp-revenue-item:hover {
    border-color: var(--vp-primary);
    background: var(--vp-primary-light);
}
.vp-revenue-label {
    font-size: 12px;
    color: var(--vp-text-3);
    font-weight: 700;
    margin-bottom: 6px;
}
.vp-revenue-value {
    font-family: 'Cairo', sans-serif;
    font-size: 22px;
    font-weight: 900;
    color: var(--vp-primary);
    line-height: 1;
}
.vp-revenue-unit {
    font-size: 12px;
    color: var(--vp-text-3);
    font-weight: 600;
    margin-right: 4px;
}

/* ==== CHARTS ROW ==== */
.vp-charts-row {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 18px;
    margin-bottom: 22px;
}
@media (max-width: 1024px) {
    .vp-charts-row { grid-template-columns: 1fr; }
}

.vp-chart-card {
    background: white;
    border-radius: 18px;
    padding: 24px;
    border: 1px solid var(--vp-border);
}

/* ==== QUICK ACTIONS ==== */
.vp-actions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 22px;
}
@media (max-width: 768px) {
    .vp-actions-grid { grid-template-columns: repeat(2, 1fr); }
}

.vp-action {
    background: white;
    border: 1px solid var(--vp-border);
    border-radius: 14px;
    padding: 20px 16px;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s;
    color: var(--vp-text);
}
.vp-action:hover {
    transform: translateY(-3px);
    border-color: var(--vp-primary);
    box-shadow: 0 12px 24px rgba(79, 70, 229, 0.12);
    background: var(--vp-primary-light);
    color: var(--vp-text);
    text-decoration: none;
}
.vp-action-icon {
    width: 48px;
    height: 48px;
    background: var(--vp-primary-light);
    color: var(--vp-primary);
    border-radius: 12px;
    margin: 0 auto 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    transition: all 0.2s;
}
.vp-action:hover .vp-action-icon {
    background: var(--vp-primary);
    color: white;
    transform: scale(1.1);
}
.vp-action-label {
    font-size: 13px;
    font-weight: 800;
    color: var(--vp-text);
}
.vp-action-sub {
    font-size: 11px;
    color: var(--vp-text-3);
    margin-top: 3px;
}

/* Override ovopanel ugly card styles */
.dashboard__area-inner .card,
.dashboard__area-inner .x-panel-ui {
    border: none !important;
}
</style>
@endpush

@section('panel')
<div class="vp-admin">

    <!-- HEADER -->
    <div class="vp-page-header">
        <div class="vp-ph-left">
            <div class="vp-ph-icon">📊</div>
            <div>
                <h2 class="vp-ph-title">لوحة التحكّم</h2>
                <div class="vp-ph-sub">ملخّص شامل لأداء Val POS</div>
            </div>
        </div>
        <div class="vp-ph-actions">
            <span class="vp-ph-badge">🟢 النظام يعمل</span>
            <span class="vp-ph-badge" style="background: #ECFDF5; color: #047857;">
                {{ \Carbon\Carbon::now()->locale('ar')->isoFormat('dddd، D MMMM YYYY') }}
            </span>
        </div>
    </div>

    <!-- USERS STATS -->
    <h3 class="vp-section-title">👥 إحصائيّات المستخدمين</h3>
    <div class="vp-stats-grid">
        <div class="vp-stat-card" data-color="indigo">
            <div class="vp-stat-icon">👥</div>
            <div class="vp-stat-label">إجمالي المستخدمين</div>
            <div class="vp-stat-value">{{ number_format($widget['total_users'] ?? 0) }}</div>
            <div class="vp-stat-sub up">⬆ منذ إنشاء النظام</div>
        </div>

        <div class="vp-stat-card" data-color="green">
            <div class="vp-stat-icon">✓</div>
            <div class="vp-stat-label">المستخدمون النشطون</div>
            <div class="vp-stat-value">{{ number_format($widget['active_users'] ?? 0) }}</div>
            <div class="vp-stat-sub up">
                @if(($widget['total_users'] ?? 0) > 0)
                    {{ round(($widget['active_users'] / $widget['total_users']) * 100, 1) }}% من الإجمالي
                @else
                    لا توجد بيانات
                @endif
            </div>
        </div>

        <div class="vp-stat-card" data-color="amber">
            <div class="vp-stat-icon">📧</div>
            <div class="vp-stat-label">بريد غير مفعّل</div>
            <div class="vp-stat-value">{{ number_format($widget['email_unverified_users'] ?? 0) }}</div>
            <div class="vp-stat-sub">يحتاج تفعيل الإيميل</div>
        </div>

        <div class="vp-stat-card" data-color="red">
            <div class="vp-stat-icon">📱</div>
            <div class="vp-stat-label">جوّال غير مفعّل</div>
            <div class="vp-stat-value">{{ number_format($widget['mobile_unverified_users'] ?? 0) }}</div>
            <div class="vp-stat-sub">يحتاج تفعيل الجوّال</div>
        </div>
    </div>

    <!-- SUBSCRIPTION REVENUE -->
    <div class="vp-revenue-section">
        <h3 class="vp-section-title">💰 إيرادات الاشتراكات</h3>
        <div class="vp-revenue-grid">
            <div class="vp-revenue-item">
                <div class="vp-revenue-label">📅 اليوم</div>
                <div class="vp-revenue-value">
                    {{ number_format($widget['today_subscription'] ?? 0, 2) }}
                    <span class="vp-revenue-unit">ر.س</span>
                </div>
            </div>
            <div class="vp-revenue-item">
                <div class="vp-revenue-label">📆 الأسبوع</div>
                <div class="vp-revenue-value">
                    {{ number_format($widget['weekly_subscription'] ?? 0, 2) }}
                    <span class="vp-revenue-unit">ر.س</span>
                </div>
            </div>
            <div class="vp-revenue-item">
                <div class="vp-revenue-label">🗓️ الشهر</div>
                <div class="vp-revenue-value">
                    {{ number_format($widget['monthly_subscription'] ?? 0, 2) }}
                    <span class="vp-revenue-unit">ر.س</span>
                </div>
            </div>
            <div class="vp-revenue-item" style="background: linear-gradient(135deg, var(--vp-primary-light), var(--vp-primary-soft)); border-color: var(--vp-primary);">
                <div class="vp-revenue-label">💎 الإجمالي الكلّي</div>
                <div class="vp-revenue-value">
                    {{ number_format($widget['total_subscription'] ?? 0, 2) }}
                    <span class="vp-revenue-unit">ر.س</span>
                </div>
            </div>
        </div>
    </div>

    <!-- CHARTS ROW -->
    <div class="vp-charts-row">
        <div class="vp-chart-card">
            <h3 class="vp-section-title">📈 المعاملات</h3>
            <x-panel.other.dashboard_trx_chart />
        </div>
        <div class="vp-chart-card">
            <h3 class="vp-section-title">📊 الدخول</h3>
            <x-panel.other.dashboard_login_chart :userLogin=$userLogin />
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <h3 class="vp-section-title">⚡ إجراءات سريعة</h3>
    <div class="vp-actions-grid">
        <a href="{{ '/admin/users/all' }}" class="vp-action">
            <div class="vp-action-icon">👥</div>
            <div class="vp-action-label">إدارة المستخدمين</div>
            <div class="vp-action-sub">عرض كل التجّار</div>
        </a>
        <a href="{{ '/admin/subscription/plan' }}" class="vp-action">
            <div class="vp-action-icon">💎</div>
            <div class="vp-action-label">الباقات</div>
            <div class="vp-action-sub">إدارة الاشتراكات</div>
        </a>
        <a href="{{ '/admin/gateways/automatic' }}" class="vp-action">
            <div class="vp-action-icon">💳</div>
            <div class="vp-action-label">بوّابات الدفع</div>
            <div class="vp-action-sub">إعدادات الدفع</div>
        </a>
        <a href="{{ '/admin/frontend/templates' }}" class="vp-action">
            <div class="vp-action-icon">🎨</div>
            <div class="vp-action-label">واجهة الموقع</div>
            <div class="vp-action-sub">تحرير المحتوى</div>
        </a>
    </div>

</div>
@endsection

@push('script-lib')
<script src="{{ asset('assets/ovopanel/js/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/ovopanel/js/charts.js') }}"></script>
<script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>
@endpush

@push('style-lib')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/css/flatpickr.min.css') }}">
@endpush

@push('script')
<script>
"use strict";
(function($) {
    $(".date-picker").flatpickr({
        mode: 'range',
        maxDate: new Date(),
    });
})(jQuery);
</script>
@endpush
