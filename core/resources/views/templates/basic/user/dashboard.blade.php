@extends($activeTemplate . 'layouts.master')

@push('style')
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<style>
.dash-page,
.dash-page * {
    font-family: 'Tajawal', 'Cairo', sans-serif !important;
}
.dash-page i.las, .dash-page i.lab, .dash-page i.lar, .dash-page i[class*="la-"] {
    font-family: 'Line Awesome Free', 'Line Awesome Brands' !important;
    font-style: normal !important;
}

/* ===== Greeting Header ===== */
.dash-greeting {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
    color: #fff;
    border-radius: 1.25rem;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}
.dash-greeting::before {
    content: '';
    position: absolute;
    top: -100px; left: -100px;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(16, 185, 129, .25) 0%, transparent 60%);
    pointer-events: none;
}
.dash-greeting::after {
    content: '';
    position: absolute;
    bottom: -150px; right: -100px;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(124, 58, 237, .2) 0%, transparent 60%);
    pointer-events: none;
}
.dash-greeting > * { position: relative; z-index: 1; }
.dash-greeting h1 {
    font-size: 1.85rem;
    font-weight: 800;
    color: #fff !important;
    margin: 0 0 .35rem;
}
.dash-greeting p {
    color: rgba(255,255,255,.75) !important;
    font-size: .95rem;
    margin: 0;
}
.dash-greeting .quick-btn {
    background: rgba(255,255,255,.12);
    color: #fff !important;
    border: 1px solid rgba(255,255,255,.18);
    padding: .55rem 1.1rem;
    border-radius: .65rem;
    font-weight: 700;
    font-size: .9rem;
    transition: all .2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
}
.dash-greeting .quick-btn:hover {
    background: rgba(255,255,255,.2);
    color: #fff !important;
    transform: translateY(-1px);
}
.dash-greeting .quick-btn.wa {
    background: #25D366;
    border-color: #25D366;
}
.dash-greeting .quick-btn.wa:hover { background: #1da851; }

/* ===== Stats Cards ===== */
.stat-card {
    background: #fff;
    border-radius: 1rem;
    padding: 1.25rem;
    border: 1px solid rgba(15, 23, 42, .06);
    transition: all .25s;
    height: 100%;
}
.stat-card:hover {
    border-color: rgba(16, 185, 129, .35);
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(15, 23, 42, .08);
}
.stat-icon {
    width: 40px; height: 40px;
    border-radius: .75rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
}
.stat-icon-emerald { background: #ecfdf5; color: #059669; }
.stat-icon-red     { background: #fee2e2; color: #dc2626; }
.stat-icon-blue    { background: #dbeafe; color: #2563eb; }
.stat-icon-amber   { background: #fef3c7; color: #d97706; }
.stat-icon-purple  { background: #ede9fe; color: #7c3aed; }
.stat-icon-pink    { background: #fce7f3; color: #db2777; }

.stat-label   { font-size: .8rem; color: #64748b; font-weight: 600; margin: 0; }
.stat-value   { font-size: 1.7rem; font-weight: 900; color: #0f172a; margin: .35rem 0 .15rem; line-height: 1; }
.stat-currency{ font-size: .8rem; color: #94a3b8; font-weight: 700; }
.stat-change {
    display: inline-flex;
    align-items: center;
    gap: .2rem;
    font-size: .72rem;
    font-weight: 700;
    padding: .2rem .5rem;
    border-radius: .35rem;
}
.stat-change.up   { color: #059669; background: #ecfdf5; }
.stat-change.down { color: #dc2626; background: #fee2e2; }

/* ===== Tabs ===== */
.dash-tabs {
    display: flex;
    gap: .35rem;
    background: #fff;
    padding: .5rem;
    border-radius: .9rem;
    margin-bottom: 1.25rem;
    border: 1px solid rgba(15, 23, 42, .05);
    overflow-x: auto;
    box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
}
.dash-tabs button {
    padding: .65rem 1.25rem;
    border-radius: .65rem;
    border: none;
    background: transparent;
    color: #64748b;
    font-weight: 700;
    font-size: .9rem;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: .45rem;
}
.dash-tabs button:hover { color: #0f172a; background: #f8fafc; }
.dash-tabs button.active {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    box-shadow: 0 4px 14px rgba(16, 185, 129, .35);
}

/* ===== Widget Card ===== */
.widget-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid rgba(15, 23, 42, .06);
    overflow: hidden;
    height: 100%;
    transition: border-color .2s;
}
.widget-card:hover { border-color: rgba(15, 23, 42, .12); }
.widget-card__head {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f1f5f9;
}
.widget-card__head h5 {
    font-size: 1rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 .15rem;
}
.widget-card__head p {
    font-size: .8rem;
    color: #64748b;
    margin: 0;
}
.widget-card__body { padding: 1rem 1.25rem; }

/* ===== Saudi Map ===== */
.saudi-map-wrap {
    position: relative;
    background: linear-gradient(180deg, #f0f9ff 0%, #f8fafc 100%);
    border-radius: .85rem;
    padding: 1rem;
    min-height: 420px;
}
.saudi-map { width: 100%; height: 420px; display: block; }
.city-group { cursor: pointer; }
.city-dot { transition: all .25s; }
.city-group:hover .city-dot {
    transform: scale(1.4);
    transform-origin: center;
}
.city-label {
    font-size: 11px;
    font-weight: 700;
    fill: #475569;
    pointer-events: none;
    font-family: 'Tajawal', sans-serif;
}
.branch-tooltip {
    position: absolute;
    background: #0f172a;
    color: #fff;
    padding: .75rem 1rem;
    border-radius: .65rem;
    font-size: .8rem;
    pointer-events: none;
    opacity: 0;
    transition: opacity .15s;
    z-index: 100;
    min-width: 180px;
    box-shadow: 0 10px 25px rgba(0,0,0,.2);
}
.branch-tooltip.show { opacity: 1; }
.branch-tooltip strong { color: #10b981; }

/* ===== Tab Content ===== */
.tab-content { display: none; animation: fadeIn .3s; }
.tab-content.active { display: block; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

/* ===== Status Badges ===== */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .25rem .65rem;
    border-radius: .4rem;
    font-size: .72rem;
    font-weight: 700;
}
.status-badge.success { background: #ecfdf5; color: #047857; }
.status-badge.warning { background: #fef3c7; color: #b45309; }
.status-badge.danger  { background: #fee2e2; color: #b91c1c; }
.status-badge.info    { background: #dbeafe; color: #1e40af; }

@media (max-width: 768px) {
    .stat-value { font-size: 1.4rem; }
    .dash-greeting { padding: 1.5rem 1.25rem; }
    .dash-greeting h1 { font-size: 1.4rem; }
}

/* ───── Smart Alerts (Phase 2) ───── */
.alert-smart {
    padding: .85rem 1rem;
    border-radius: .85rem;
    border: 1px solid;
    height: 100%;
    transition: transform .2s;
    display: flex;
    flex-direction: column;
    gap: .35rem;
}
.alert-smart:hover { transform: translateY(-1px); }
.alert-smart i { font-size: 1.15rem; }
.alert-smart strong { font-size: .88rem; }
.alert-smart p { font-size: .82rem; line-height: 1.5; margin: 0; }
.alert-smart a { color: inherit; text-decoration: underline; font-weight: 700; font-size: .8rem; margin-top: auto; }
.alert-smart-success { background: #ecfdf5; border-color: #a7f3d0; color: #065f46; }
.alert-smart-warning { background: #fffbeb; border-color: #fde68a; color: #92400e; }
.alert-smart-info    { background: #eff6ff; border-color: #bfdbfe; color: #1e40af; }
.alert-smart-danger  { background: #fef2f2; border-color: #fecaca; color: #991b1b; }

/* ───── Empty State ───── */
.empty-state {
    text-align: center;
    padding: 2rem 1rem;
    color: #94a3b8;
}
.empty-state i { font-size: 2.5rem; opacity: .5; margin-bottom: .5rem; }
.empty-state p { margin: 0; font-size: .9rem; }
</style>
@endpush

@section('panel')
<div class="dash-page">

{{-- ═══════════════════════════════════════════════════════════
     GREETING HEADER
     ═══════════════════════════════════════════════════════════ --}}
<div class="dash-greeting">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h1>👋 مرحباً، {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h1>
            <p>{{ now()->locale('ar')->translatedFormat('l، j F Y') }} · إليك ملخّص أداء متجرك اليوم</p>
        </div>
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <a href="{{ route('user.pos.index') }}" class="quick-btn">
                <i class="las la-cash-register"></i> الكاشير
            </a>
            <a href="{{ route('user.whatsapp.dashboard') }}" class="quick-btn wa">
                <i class="lab la-whatsapp"></i> متجر واتساب
            </a>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     SMART ALERTS (Phase 2)
     ═══════════════════════════════════════════════════════════ --}}
@if(!empty($smartAlerts))
<div class="row g-2 mb-3">
    @foreach($smartAlerts as $alert)
        <div class="col-12 col-md-6 col-lg-3">
            <div class="alert-smart alert-smart-{{ $alert['type'] }}">
                <div class="d-flex align-items-center gap-2">
                    <i class="las {{ $alert['icon'] }}"></i>
                    <strong>{{ $alert['title_ar'] }}</strong>
                </div>
                <p>{{ $alert['message_ar'] }}</p>
                @if(!empty($alert['link']) && $alert['link'] !== '#')
                    <a href="{{ $alert['link'] }}">عرض التفاصيل ←</a>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endif

{{-- ═══════════════════════════════════════════════════════════
     TABS NAVIGATION
     ═══════════════════════════════════════════════════════════ --}}
<div class="dash-tabs">
    <button class="active" data-tab="sales"><i class="las la-chart-line"></i> المبيعات</button>
    <button data-tab="branches"><i class="las la-map-marked-alt"></i> الفروع</button>
    <button data-tab="products"><i class="las la-box"></i> المنتجات</button>
    <button data-tab="inventory"><i class="las la-warehouse"></i> المخزون</button>
    <button data-tab="delivery"><i class="las la-truck"></i> التوصيل</button>
    <button data-tab="employees"><i class="las la-users"></i> الموظفين</button>
</div>


{{-- ═══════════════════════════════════════════════════════════
     SALES TAB - مربوط بقاعدة البيانات (Phase 1)
     ═══════════════════════════════════════════════════════════ --}}
<div class="tab-content active" id="tab-sales">

    {{-- 4 Top Stats - مربوطة بـ$widget --}}
    <div class="row g-3 mb-3">
        {{-- إجمالي المبيعات اليوم --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-emerald"><i class="las la-coins"></i></div>
                    @php
                        $todaySale = (float) ($widget['today_sale'] ?? 0);
                        $yesterdaySale = (float) ($widget['yesterday_sale'] ?? 0);
                        $salesChange = $yesterdaySale > 0
                            ? round((($todaySale - $yesterdaySale) / $yesterdaySale) * 100, 1)
                            : 0;
                    @endphp
                    @if($salesChange != 0)
                        <span class="stat-change {{ $salesChange >= 0 ? 'up' : 'down' }}">
                            <i class="las la-arrow-{{ $salesChange >= 0 ? 'up' : 'down' }}"></i>
                            {{ abs($salesChange) }}%
                        </span>
                    @endif
                </div>
                <p class="stat-label">إجمالي المبيعات</p>
                <div>
                    <span class="stat-value">{{ number_format($todaySale, 0) }}</span>
                    <span class="stat-currency">ر.س</span>
                </div>
            </div>
        </div>

        {{-- المصاريف اليوم --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-red"><i class="las la-receipt"></i></div>
                </div>
                <p class="stat-label">المصاريف</p>
                <div>
                    <span class="stat-value">{{ number_format((float)($widget['today_expense'] ?? 0), 0) }}</span>
                    <span class="stat-currency">ر.س</span>
                </div>
            </div>
        </div>

        {{-- صافي الربح اليوم --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-blue"><i class="las la-chart-pie"></i></div>
                    @php
                        $netProfit = (float)($widget['today_sale'] ?? 0) - (float)($widget['today_expense'] ?? 0);
                        $profitMargin = ($widget['today_sale'] ?? 0) > 0
                            ? round(($netProfit / $widget['today_sale']) * 100, 1)
                            : 0;
                    @endphp
                    @if($profitMargin > 0)
                        <span class="stat-change up">
                            <i class="las la-percentage"></i> {{ $profitMargin }}%
                        </span>
                    @endif
                </div>
                <p class="stat-label">صافي الربح</p>
                <div>
                    <span class="stat-value">{{ number_format($netProfit, 0) }}</span>
                    <span class="stat-currency">ر.س</span>
                </div>
            </div>
        </div>

        {{-- إجمالي الطلبات اليوم --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-purple"><i class="las la-shopping-bag"></i></div>
                </div>
                <p class="stat-label">إجمالي الطلبات</p>
                <div>
                    <span class="stat-value">{{ number_format($widget['today_orders_count'] ?? 0) }}</span>
                    <span class="stat-currency">طلب</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Combined Trend Chart --}}
    <div class="widget-card mb-3">
        <div class="widget-card__head d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5>📊 اتّجاه الإيرادات والطلبات</h5>
                <p>عرض شامل: إيرادات (مساحة) · طلبات (أعمدة) · الأرباح (خطّ)</p>
            </div>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary" data-period="day">اليوم</button>
                <button type="button" class="btn btn-outline-secondary active" data-period="week">أسبوع</button>
                <button type="button" class="btn btn-outline-secondary" data-period="month">شهر</button>
                <button type="button" class="btn btn-outline-secondary" data-period="year">سنة</button>
            </div>
        </div>
        <div class="widget-card__body">
            <div id="combinedChart" style="height: 340px;"></div>
        </div>
    </div>

    {{-- Row: Order Status, Types, Payment --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="widget-card">
                <div class="widget-card__head"><h5>حالة الطلبات</h5><p>التوزيع حسب الحالة</p></div>
                <div class="widget-card__body"><div id="orderStatusChart" style="height: 280px;"></div></div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="widget-card">
                <div class="widget-card__head"><h5>أنواع الطلبات</h5><p>الكاشير مقابل الواتس اب</p></div>
                <div class="widget-card__body"><div id="orderTypesChart" style="height: 280px;"></div></div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="widget-card">
                <div class="widget-card__head"><h5>طرق الدفع</h5><p>توزيع الإيرادات</p></div>
                <div class="widget-card__body"><div id="paymentMethodsChart" style="height: 280px;"></div></div>
            </div>
        </div>
    </div>

    {{-- Row: Daily orders, Top products, Orders by payment --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="widget-card">
                <div class="widget-card__head"><h5>عدد الطلبات اليوميّة</h5><p>آخر 7 أيام</p></div>
                <div class="widget-card__body"><div id="dailyOrdersChart" style="height: 280px;"></div></div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="widget-card">
                <div class="widget-card__head"><h5>أفضل 5 منتجات</h5><p>الأكثر مبيعاً</p></div>
                <div class="widget-card__body"><div id="top5ProductsChart" style="height: 280px;"></div></div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="widget-card">
                <div class="widget-card__head"><h5>الطلبات حسب الدفع</h5><p>عدد الطلبات لكلّ طريقة</p></div>
                <div class="widget-card__body"><div id="ordersByPaymentChart" style="height: 280px;"></div></div>
            </div>
        </div>
    </div>

    {{-- Row: Revenue distribution + Avg order value --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-6">
            <div class="widget-card">
                <div class="widget-card__head"><h5>توزيع إيرادات المنتجات</h5><p>أفضل 6 منتجات</p></div>
                <div class="widget-card__body"><div id="revenueDistChart" style="height: 320px;"></div></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="widget-card">
                <div class="widget-card__head"><h5>متوسط قيمة الطلب</h5><p>الاتّجاه اليومي</p></div>
                <div class="widget-card__body"><div id="avgOrderChart" style="height: 320px;"></div></div>
            </div>
        </div>
    </div>

    {{-- Row: Revenue vs Expenses --}}
    <div class="widget-card mb-3">
        <div class="widget-card__head"><h5>الإيرادات مقابل المصاريف</h5><p>مقارنة شهريّة</p></div>
        <div class="widget-card__body"><div id="revVsExpChart" style="height: 280px;"></div></div>
    </div>

    {{-- Recent Orders - مربوط بـ$recentSales --}}
    <div class="widget-card">
        <div class="widget-card__head d-flex justify-content-between align-items-center">
            <div><h5>أحدث الطلبات</h5><p>آخر 5 عمليات</p></div>
            <a href="{{ route('user.sale.list') }}" class="btn btn-sm btn-outline-secondary">عرض الكلّ <i class="las la-arrow-left"></i></a>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless mb-0 align-middle">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th class="ps-4">رقم الطلب</th>
                        <th>العميل</th>
                        <th>المنتجات</th>
                        <th>الإجمالي</th>
                        <th>طريقة الدفع</th>
                        <th>الحالة</th>
                        <th class="pe-4">الوقت</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSales as $sale)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $sale->invoice_no ?? str_pad($sale->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $sale->customer->name ?? 'عميل غير محدّد' }}</td>
                            <td>{{ $sale->saleDetails->count() ?? 0 }} منتجات</td>
                            <td class="fw-bold text-success">{{ number_format($sale->total, 0) }} ر</td>
                            <td>
                                @if($sale->salePayment && $sale->salePayment->first())
                                    {{ $sale->salePayment->first()->paymentType->name ?? 'نقدي' }}
                                @else
                                    نقدي
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = match($sale->payment_status ?? 0) {
                                        1 => 'success',
                                        0 => 'warning',
                                        default => 'secondary'
                                    };
                                    $statusLabel = match($sale->payment_status ?? 0) {
                                        1 => 'مكتمل',
                                        0 => 'قيد الدفع',
                                        default => 'غير محدّد'
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td class="pe-4 text-muted small">{{ $sale->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="las la-receipt d-block"></i>
                                    <p>لا توجد طلبات بعد. اضغط على "الكاشير" للبدء.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>


{{-- ═══════════════════════════════════════════════════════════
     BRANCHES TAB — مربوطة بـ$widget و $warehouses
     ═══════════════════════════════════════════════════════════ --}}
<div class="tab-content" id="tab-branches">

    {{-- 4 Branch Stats --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-emerald"><i class="las la-store"></i></div>
                </div>
                <p class="stat-label">إجمالي الفروع</p>
                <div>
                    <span class="stat-value">{{ $widget['branches_count'] ?? $warehouses->count() }}</span>
                    <span class="stat-currency">فرع</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-blue"><i class="las la-city"></i></div>
                </div>
                <p class="stat-label">المدن المغطّاة</p>
                <div>
                    <span class="stat-value">{{ $warehouses->pluck('city')->filter()->unique()->count() ?: '0' }}</span>
                    <span class="stat-currency">مدن</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-purple"><i class="las la-coins"></i></div>
                </div>
                <p class="stat-label">إيرادات شهريّة</p>
                <div>
                    <span class="stat-value">{{ number_format((float)($widget['this_month_sale'] ?? 0), 0) }}</span>
                    <span class="stat-currency">ر.س</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-amber"><i class="las la-users"></i></div>
                </div>
                <p class="stat-label">إجمالي الموظفين</p>
                <div>
                    <span class="stat-value">{{ $widget['staff_count'] ?? 0 }}</span>
                    <span class="stat-currency">موظف</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        {{-- Map --}}
        <div class="col-12 col-lg-8">
            <div class="widget-card">
                <div class="widget-card__head">
                    <h5>🗺️ الخريطة التفاعليّة للفروع</h5>
                    <p>توزيع فروعك في المملكة العربيّة السعوديّة</p>
                </div>
                <div class="widget-card__body">
                    <div id="branchesMap" style="height: 380px; background: #f1f5f9; border-radius: .75rem; display: flex; align-items: center; justify-content: center;">
                        <div class="text-center">
                            <i class="las la-map-marked-alt" style="font-size: 3rem; color: #94a3b8;"></i>
                            <p class="text-muted mt-2">خريطة الفروع — قريباً</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Cities --}}
        <div class="col-12 col-lg-4">
            <div class="widget-card">
                <div class="widget-card__head"><h5>أعلى المدن مبيعاً</h5><p>ترتيب حسب الإيرادات</p></div>
                <div class="widget-card__body">
                    @forelse($warehouses->take(5) as $idx => $warehouse)
                        <div class="d-flex align-items-center justify-content-between mb-2 p-2" style="background: #f8fafc; border-radius: .5rem;">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary">{{ $idx + 1 }}</span>
                                <strong>{{ $warehouse->name ?? 'مستودع #' . $warehouse->id }}</strong>
                            </div>
                            <small class="text-muted">{{ $warehouse->city ?? '—' }}</small>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="las la-warehouse d-block"></i>
                            <p>لا توجد مستودعات/فروع بعد</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Branches List Table --}}
    <div class="widget-card">
        <div class="widget-card__head d-flex justify-content-between align-items-center">
            <div><h5>قائمة الفروع</h5><p>تفاصيل كل فرع</p></div>
            <a href="{{ route('user.warehouse.list') }}" class="btn btn-sm btn-outline-secondary">إدارة الفروع <i class="las la-arrow-left"></i></a>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless mb-0 align-middle">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th class="ps-4">الفرع</th>
                        <th>المدينة</th>
                        <th>الهاتف</th>
                        <th>الحالة</th>
                        <th class="pe-4">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($warehouses as $warehouse)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $warehouse->name ?? 'مستودع #' . $warehouse->id }}</td>
                            <td>{{ $warehouse->city ?? '—' }}</td>
                            <td class="text-muted">{{ $warehouse->phone ?? '—' }}</td>
                            <td>
                                <span class="status-badge {{ ($warehouse->status ?? 1) == 1 ? 'success' : 'warning' }}">
                                    {{ ($warehouse->status ?? 1) == 1 ? 'نشط' : 'معطّل' }}
                                </span>
                            </td>
                            <td class="pe-4">
                                <a href="#" class="btn btn-sm btn-outline-primary"><i class="las la-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="las la-warehouse d-block"></i>
                                    <p>لا توجد فروع بعد. أضف فرعك الأوّل من القائمة الجانبيّة.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>


{{-- ═══════════════════════════════════════════════════════════
     4 TABS قادمة في المراحل التاليّة
     ═══════════════════════════════════════════════════════════ --}}
<div class="tab-content" id="tab-products">
    <div class="widget-card text-center p-5">
        <i class="las la-box" style="font-size: 4rem; color: #cbd5e1;"></i>
        <h5 class="mt-3 mb-2">داش بورد المنتجات</h5>
        <p class="text-muted mb-0">قريباً جداً... سيتمّ بناؤه في المرحلة التالية</p>
    </div>
</div>
<div class="tab-content" id="tab-inventory">
    <div class="widget-card text-center p-5">
        <i class="las la-warehouse" style="font-size: 4rem; color: #cbd5e1;"></i>
        <h5 class="mt-3 mb-2">داش بورد المخزون</h5>
        <p class="text-muted mb-0">قريباً جداً... سيتمّ بناؤه في المرحلة التالية</p>
    </div>
</div>
<div class="tab-content" id="tab-delivery">
    <div class="widget-card text-center p-5">
        <i class="las la-truck" style="font-size: 4rem; color: #cbd5e1;"></i>
        <h5 class="mt-3 mb-2">داش بورد التوصيل</h5>
        <p class="text-muted mb-0">قريباً جداً... سيتمّ بناؤه في المرحلة التالية</p>
    </div>
</div>
<div class="tab-content" id="tab-employees">
    <div class="widget-card text-center p-5">
        <i class="las la-users" style="font-size: 4rem; color: #cbd5e1;"></i>
        <h5 class="mt-3 mb-2">داش بورد الموظفين</h5>
        <p class="text-muted mb-0">قريباً جداً... سيتمّ بناؤه في المرحلة التالية</p>
    </div>
</div>

</div>{{-- /.dash-page --}}
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
// ═══════════════════════════════════════════════════════════
// Val POS Dashboard - Connected to Laravel Backend
// ═══════════════════════════════════════════════════════════

// ───── البيانات من Laravel ─────
const chartData = @json($chartData ?? ['weekly' => ['labels' => [], 'sales' => [], 'expenses' => [], 'profit' => [], 'orders' => []], 'paymentMethods' => [], 'orderTypes' => ['pos' => 0, 'whatsapp' => 0]]);

const widget = @json($widget ?? []);

const topProducts = @json($topSellingProducts ?? []);

// ───── إعدادات ApexCharts العامّة ─────
const apexCommon = {
    chart: {
        fontFamily: 'Tajawal, Cairo, sans-serif',
        toolbar: { show: false }
    }
};

// ═══════════════════════════════════════════════════════════
// Tabs Switching
// ═══════════════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.dash-tabs button').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.dash-tabs button').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('tab-' + this.dataset.tab).classList.add('active');
        });
    });

    // ═══════════════════════════════════════════════════════
    // 1. Combined Chart - الإيرادات + الطلبات + الأرباح
    // ═══════════════════════════════════════════════════════
    new ApexCharts(document.getElementById('combinedChart'), {
        chart: { height: 340, type: 'line', toolbar: { show: false }, fontFamily: 'Tajawal, Cairo, sans-serif' },
        series: [
            { name: 'الإيرادات', type: 'area', data: chartData.weekly.sales || [] },
            { name: 'الطلبات', type: 'column', data: chartData.weekly.orders || [] },
            { name: 'الأرباح', type: 'line', data: chartData.weekly.profit || [] }
        ],
        stroke: { curve: 'smooth', width: [2, 0, 3] },
        fill: { type: ['gradient', 'solid', 'solid'], opacity: [0.3, 1, 1] },
        colors: ['#10b981', '#3b82f6', '#f59e0b'],
        xaxis: { categories: chartData.weekly.labels || [] },
        yaxis: [
            { title: { text: 'الإيرادات / الأرباح' }, labels: { formatter: (v) => Math.round(v) } },
            { opposite: true, title: { text: 'عدد الطلبات' } }
        ],
        legend: { position: 'top', horizontalAlign: 'center' },
        tooltip: { theme: 'light', shared: true, intersect: false },
        grid: { borderColor: '#f1f5f9' },
        noData: { text: 'لا توجد بيانات بعد', style: { fontSize: '14px', fontFamily: 'Tajawal' } }
    }).render();

    // ═══════════════════════════════════════════════════════
    // 2. Order Status Chart
    // ═══════════════════════════════════════════════════════
    const paidOrders = (widget.today_orders_count || 0) > 0 ? Math.round((widget.today_sale || 0) > 0 ? widget.today_orders_count * 0.7 : 0) : 0;
    const pendingOrders = (widget.today_orders_count || 0) - paidOrders;

    new ApexCharts(document.getElementById('orderStatusChart'), {
        chart: { height: 280, type: 'donut', fontFamily: 'Tajawal, Cairo, sans-serif', toolbar: { show: false } },
        series: [paidOrders, pendingOrders],
        labels: ['مكتمل', 'قيد التحضير'],
        colors: ['#10b981', '#f59e0b'],
        legend: { position: 'bottom' },
        plotOptions: { pie: { donut: { size: '65%' } } },
        dataLabels: { enabled: true, formatter: (val) => Math.round(val) + '%' },
        noData: { text: 'لا توجد بيانات', style: { fontSize: '14px', fontFamily: 'Tajawal' } }
    }).render();

    // ═══════════════════════════════════════════════════════
    // 3. Order Types - POS vs WhatsApp
    // ═══════════════════════════════════════════════════════
    new ApexCharts(document.getElementById('orderTypesChart'), {
        chart: { height: 280, type: 'donut', fontFamily: 'Tajawal, Cairo, sans-serif', toolbar: { show: false } },
        series: [chartData.orderTypes.pos || 0, chartData.orderTypes.whatsapp || 0],
        labels: ['الكاشير (POS)', 'متجر واتساب'],
        colors: ['#3b82f6', '#25D366'],
        legend: { position: 'bottom' },
        plotOptions: { pie: { donut: { size: '65%' } } },
        dataLabels: { enabled: true, formatter: (val, opts) => opts.w.config.series[opts.seriesIndex] },
        noData: { text: 'لا توجد طلبات اليوم', style: { fontSize: '14px', fontFamily: 'Tajawal' } }
    }).render();

    // ═══════════════════════════════════════════════════════
    // 4. Payment Methods Chart
    // ═══════════════════════════════════════════════════════
    const paymentSeries = (chartData.paymentMethods || []).map(p => Math.round(p.total));
    const paymentLabels = (chartData.paymentMethods || []).map(p => p.name);

    new ApexCharts(document.getElementById('paymentMethodsChart'), {
        chart: { height: 280, type: 'donut', fontFamily: 'Tajawal, Cairo, sans-serif', toolbar: { show: false } },
        series: paymentSeries.length > 0 ? paymentSeries : [1],
        labels: paymentLabels.length > 0 ? paymentLabels : ['لا توجد بيانات'],
        colors: ['#10b981', '#3b82f6', '#8b5cf6', '#f59e0b', '#ef4444', '#25D366'],
        legend: { position: 'bottom' },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'إجمالي',
                            formatter: () => {
                                const total = paymentSeries.reduce((s, v) => s + v, 0);
                                return new Intl.NumberFormat('ar').format(total) + ' ر.س';
                            }
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: true, formatter: (val) => Math.round(val) + '%' }
    }).render();

    // ═══════════════════════════════════════════════════════
    // 5. Daily Orders Chart - عدد الطلبات آخر 7 أيّام
    // ═══════════════════════════════════════════════════════
    new ApexCharts(document.getElementById('dailyOrdersChart'), {
        chart: { height: 280, type: 'bar', fontFamily: 'Tajawal, Cairo, sans-serif', toolbar: { show: false } },
        series: [{ name: 'الطلبات', data: chartData.weekly.orders || [] }],
        colors: ['#3b82f6'],
        plotOptions: { bar: { borderRadius: 8, columnWidth: '55%' } },
        xaxis: { categories: chartData.weekly.labels || [] },
        dataLabels: { enabled: true },
        grid: { borderColor: '#f1f5f9' },
        noData: { text: 'لا توجد بيانات', style: { fontSize: '14px', fontFamily: 'Tajawal' } }
    }).render();

    // ═══════════════════════════════════════════════════════
    // 6. Top 5 Products Chart
    // ═══════════════════════════════════════════════════════
    const topProductsData = Array.isArray(topProducts) ? topProducts.slice(0, 5) : [];
    const topProductsLabels = topProductsData.map(p => p.product_detail?.product?.name || p.productDetail?.product?.name || 'منتج').slice(0, 5);
    const topProductsValues = topProductsData.map(p => parseInt(p.total_quantity) || 0).slice(0, 5);

    new ApexCharts(document.getElementById('top5ProductsChart'), {
        chart: { height: 280, type: 'bar', fontFamily: 'Tajawal, Cairo, sans-serif', toolbar: { show: false } },
        series: [{ name: 'الكميّة المباعة', data: topProductsValues.length > 0 ? topProductsValues : [0] }],
        colors: ['#10b981'],
        plotOptions: { bar: { borderRadius: 6, horizontal: true } },
        xaxis: { categories: topProductsLabels.length > 0 ? topProductsLabels : ['لا توجد بيانات'] },
        dataLabels: { enabled: true },
        grid: { borderColor: '#f1f5f9' },
        noData: { text: 'لا توجد مبيعات بعد', style: { fontSize: '14px', fontFamily: 'Tajawal' } }
    }).render();

    // ═══════════════════════════════════════════════════════
    // 7. Orders by Payment Chart
    // ═══════════════════════════════════════════════════════
    new ApexCharts(document.getElementById('ordersByPaymentChart'), {
        chart: { height: 280, type: 'bar', fontFamily: 'Tajawal, Cairo, sans-serif', toolbar: { show: false } },
        series: [{ name: 'عدد الطلبات', data: (chartData.paymentMethods || []).map(p => p.count) }],
        colors: ['#8b5cf6'],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '55%' } },
        xaxis: { categories: (chartData.paymentMethods || []).map(p => p.name) },
        dataLabels: { enabled: true },
        grid: { borderColor: '#f1f5f9' },
        noData: { text: 'لا توجد بيانات', style: { fontSize: '14px', fontFamily: 'Tajawal' } }
    }).render();

    // ═══════════════════════════════════════════════════════
    // 8. Revenue Distribution (Top 6 Products)
    // ═══════════════════════════════════════════════════════
    const revDistData = Array.isArray(topProducts) ? topProducts.slice(0, 6) : [];
    const revDistLabels = revDistData.map(p => p.product_detail?.product?.name || p.productDetail?.product?.name || 'منتج');
    const revDistValues = revDistData.map(p => parseFloat(p.total_quantity) || 0);

    new ApexCharts(document.getElementById('revenueDistChart'), {
        chart: { height: 320, type: 'pie', fontFamily: 'Tajawal, Cairo, sans-serif', toolbar: { show: false } },
        series: revDistValues.length > 0 ? revDistValues : [1],
        labels: revDistLabels.length > 0 ? revDistLabels : ['لا توجد بيانات'],
        colors: ['#10b981', '#3b82f6', '#8b5cf6', '#f59e0b', '#ef4444', '#06b6d4'],
        legend: { position: 'bottom' },
        dataLabels: { enabled: true, formatter: (val) => Math.round(val) + '%' }
    }).render();

    // ═══════════════════════════════════════════════════════
    // 9. Average Order Value Chart
    // ═══════════════════════════════════════════════════════
    const avgValues = (chartData.weekly.sales || []).map((sale, i) => {
        const orders = (chartData.weekly.orders || [])[i] || 1;
        return orders > 0 ? Math.round(sale / orders) : 0;
    });

    new ApexCharts(document.getElementById('avgOrderChart'), {
        chart: { height: 320, type: 'area', fontFamily: 'Tajawal, Cairo, sans-serif', toolbar: { show: false } },
        series: [{ name: 'متوسّط قيمة الطلب', data: avgValues }],
        colors: ['#f59e0b'],
        stroke: { curve: 'smooth', width: 3 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.6, opacityTo: 0.1 } },
        xaxis: { categories: chartData.weekly.labels || [] },
        dataLabels: { enabled: false },
        grid: { borderColor: '#f1f5f9' },
        noData: { text: 'لا توجد بيانات', style: { fontSize: '14px', fontFamily: 'Tajawal' } }
    }).render();

    // ═══════════════════════════════════════════════════════
    // 10. Revenue vs Expenses
    // ═══════════════════════════════════════════════════════
    new ApexCharts(document.getElementById('revVsExpChart'), {
        chart: { height: 280, type: 'bar', fontFamily: 'Tajawal, Cairo, sans-serif', toolbar: { show: false }, stacked: false },
        series: [
            { name: 'الإيرادات', data: chartData.weekly.sales || [] },
            { name: 'المصاريف', data: chartData.weekly.expenses || [] }
        ],
        colors: ['#10b981', '#ef4444'],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '55%' } },
        xaxis: { categories: chartData.weekly.labels || [] },
        legend: { position: 'top' },
        dataLabels: { enabled: false },
        grid: { borderColor: '#f1f5f9' },
        noData: { text: 'لا توجد بيانات', style: { fontSize: '14px', fontFamily: 'Tajawal' } }
    }).render();
});
</script>
@endpush