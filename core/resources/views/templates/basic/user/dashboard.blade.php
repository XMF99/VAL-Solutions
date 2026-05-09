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
            <h1>👋 مرحباً، {{ auth()->user()->firstname ?? 'أحمد' }}</h1>
            <p>{{ now()->locale('ar')->translatedFormat('l، j F Y') }} · إليك ملخّص أداء متجرك اليوم</p>
        </div>
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <a href="{{ route('user.pos.index') ?? '#' }}" class="quick-btn">
                <i class="las la-cash-register"></i> الكاشير
            </a>
            <a href="{{ route('user.whatsapp.dashboard') ?? '#' }}" class="quick-btn wa">
                <i class="lab la-whatsapp"></i> متجر واتساب
            </a>
        </div>
    </div>
</div>

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
     SALES TAB
     ═══════════════════════════════════════════════════════════ --}}
<div class="tab-content active" id="tab-sales">

    {{-- 4 Top Stats --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-emerald"><i class="las la-coins"></i></div>
                    <span class="stat-change up"><i class="las la-arrow-up"></i> 18.5%</span>
                </div>
                <p class="stat-label">إجمالي المبيعات</p>
                <div><span class="stat-value">12,450</span> <span class="stat-currency">ر.س</span></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-red"><i class="las la-receipt"></i></div>
                    <span class="stat-change down"><i class="las la-arrow-down"></i> 5.2%</span>
                </div>
                <p class="stat-label">المصاريف</p>
                <div><span class="stat-value">2,340</span> <span class="stat-currency">ر.س</span></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-blue"><i class="las la-chart-pie"></i></div>
                    <span class="stat-change up"><i class="las la-arrow-up"></i> 22.1%</span>
                </div>
                <p class="stat-label">صافي الربح</p>
                <div><span class="stat-value">10,110</span> <span class="stat-currency">ر.س</span></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-purple"><i class="las la-shopping-bag"></i></div>
                    <span class="stat-change up"><i class="las la-arrow-up"></i> 12.3%</span>
                </div>
                <p class="stat-label">إجمالي الطلبات</p>
                <div><span class="stat-value">87</span> <span class="stat-currency">طلب</span></div>
            </div>
        </div>
    </div>

    {{-- Combined Trend Chart --}}
    <div class="widget-card mb-3">
        <div class="widget-card__head d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5>📊 اتّجاه الإيرادات والطلبات</h5>
                <p>عرض شامل: إيرادات (مساحة) · طلبات (أعمدة) · النموّ (خطّ)</p>
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

    {{-- Recent Orders --}}
    <div class="widget-card">
        <div class="widget-card__head d-flex justify-content-between align-items-center">
            <div><h5>أحدث الطلبات</h5><p>آخر 5 عمليات</p></div>
            <a href="#" class="btn btn-sm btn-outline-secondary">عرض الكلّ <i class="las la-arrow-left"></i></a>
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
                    <tr><td class="ps-4 fw-bold">#1247</td><td>محمد العتيبي</td><td>3 منتجات</td><td class="fw-bold text-success">285 ر</td><td>مدى</td><td><span class="status-badge success">مكتمل</span></td><td class="pe-4 text-muted small">قبل 5د</td></tr>
                    <tr><td class="ps-4 fw-bold">#1246</td><td>سارة الأحمد</td><td>2 منتجات</td><td class="fw-bold text-success">145 ر</td><td>نقدي</td><td><span class="status-badge success">مكتمل</span></td><td class="pe-4 text-muted small">قبل 12د</td></tr>
                    <tr><td class="ps-4 fw-bold">#1245</td><td>فهد الدوسري</td><td>5 منتجات</td><td class="fw-bold text-success">320 ر</td><td>Apple Pay</td><td><span class="status-badge warning">قيد التحضير</span></td><td class="pe-4 text-muted small">قبل 18د</td></tr>
                    <tr><td class="ps-4 fw-bold">#1244</td><td>نورا الشمري</td><td>1 منتج</td><td class="fw-bold text-success">75 ر</td><td>مدى</td><td><span class="status-badge success">مكتمل</span></td><td class="pe-4 text-muted small">قبل 25د</td></tr>
                    <tr><td class="ps-4 fw-bold">#1243</td><td>خالد القحطاني</td><td>4 منتجات</td><td class="fw-bold text-success">210 ر</td><td><i class="lab la-whatsapp text-success"></i> واتساب</td><td><span class="status-badge success">مكتمل</span></td><td class="pe-4 text-muted small">قبل 35د</td></tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════════
     BRANCHES TAB — Saudi Arabia Map
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
                <div><span class="stat-value">7</span> <span class="stat-currency">فرع</span></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-blue"><i class="las la-city"></i></div>
                </div>
                <p class="stat-label">المدن المغطّاة</p>
                <div><span class="stat-value">5</span> <span class="stat-currency">مدن</span></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-purple"><i class="las la-coins"></i></div>
                </div>
                <p class="stat-label">إيرادات شهريّة</p>
                <div><span class="stat-value">144,280</span> <span class="stat-currency">ر.س</span></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="stat-icon stat-icon-amber"><i class="las la-users"></i></div>
                </div>
                <p class="stat-label">إجمالي الموظفين</p>
                <div><span class="stat-value">30</span> <span class="stat-currency">موظف</span></div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        {{-- Map --}}
        <div class="col-12 col-lg-8">
            <div class="widget-card">
                <div class="widget-card__head">
                    <h5>🇸🇦 خريطة الفروع — المملكة العربيّة السعوديّة</h5>
                    <p>حرّك الفأرة على المدينة لرؤية تفاصيل الفروع والإيرادات</p>
                </div>
                <div class="widget-card__body">
                    <div class="saudi-map-wrap" id="saudiMapWrap">
                        <svg class="saudi-map" viewBox="0 0 800 500" xmlns="http://www.w3.org/2000/svg">
                            {{-- Saudi Arabia simplified shape --}}
                            <path d="M 130 80 L 200 60 L 290 80 L 380 100 L 450 130 L 510 170 L 540 220 L 560 260 L 580 290 L 620 310 L 640 350 L 600 400 L 540 430 L 460 440 L 380 420 L 300 410 L 230 380 L 170 340 L 130 280 L 110 220 L 100 160 Z"
                                  fill="#dbeafe" stroke="#2563eb" stroke-width="2" opacity="0.5"/>

                            {{-- Cities (with branches) --}}
                            <g class="city-group" data-city="الرياض" data-revenue="45230" data-orders="287" data-branches="3">
                                <circle class="city-dot" cx="400" cy="240" r="14" fill="#10b981" stroke="#fff" stroke-width="3"/>
                                <text class="city-label" x="400" y="270" text-anchor="middle">الرياض</text>
                            </g>
                            <g class="city-group" data-city="جدة" data-revenue="38450" data-orders="245" data-branches="2">
                                <circle class="city-dot" cx="220" cy="290" r="13" fill="#3b82f6" stroke="#fff" stroke-width="3"/>
                                <text class="city-label" x="220" y="320" text-anchor="middle">جدة</text>
                            </g>
                            <g class="city-group" data-city="مكة المكرّمة" data-revenue="28900" data-orders="178" data-branches="1">
                                <circle class="city-dot" cx="240" cy="335" r="10" fill="#8b5cf6" stroke="#fff" stroke-width="3"/>
                                <text class="city-label" x="240" y="365" text-anchor="middle">مكة</text>
                            </g>
                            <g class="city-group" data-city="المدينة المنوّرة" data-revenue="19800" data-orders="124" data-branches="1">
                                <circle class="city-dot" cx="240" cy="200" r="10" fill="#f59e0b" stroke="#fff" stroke-width="3"/>
                                <text class="city-label" x="240" y="185" text-anchor="middle">المدينة</text>
                            </g>
                            <g class="city-group" data-city="الدمّام" data-revenue="32100" data-orders="201" data-branches="2">
                                <circle class="city-dot" cx="540" cy="220" r="11" fill="#ef4444" stroke="#fff" stroke-width="3"/>
                                <text class="city-label" x="540" y="205" text-anchor="middle">الدمّام</text>
                            </g>
                            <g class="city-group" data-city="تبوك" data-revenue="11200" data-orders="78" data-branches="1">
                                <circle class="city-dot" cx="170" cy="120" r="9" fill="#06b6d4" stroke="#fff" stroke-width="3"/>
                                <text class="city-label" x="170" y="105" text-anchor="middle">تبوك</text>
                            </g>
                            <g class="city-group" data-city="أبها" data-revenue="9800" data-orders="62" data-branches="1">
                                <circle class="city-dot" cx="290" cy="430" r="8" fill="#ec4899" stroke="#fff" stroke-width="3"/>
                                <text class="city-label" x="290" y="455" text-anchor="middle">أبها</text>
                            </g>
                            <g class="city-group" data-city="حائل" data-revenue="7400" data-orders="48" data-branches="0">
                                <circle class="city-dot" cx="320" cy="160" r="7" fill="#a855f7" stroke="#fff" stroke-width="3" opacity="0.6"/>
                                <text class="city-label" x="320" y="145" text-anchor="middle">حائل</text>
                            </g>
                            <g class="city-group" data-city="بريدة" data-revenue="13500" data-orders="89" data-branches="1">
                                <circle class="city-dot" cx="370" cy="190" r="9" fill="#22c55e" stroke="#fff" stroke-width="3"/>
                                <text class="city-label" x="370" y="175" text-anchor="middle">بريدة</text>
                            </g>
                            <g class="city-group" data-city="جازان" data-revenue="6800" data-orders="42" data-branches="0">
                                <circle class="city-dot" cx="260" cy="445" r="6" fill="#f97316" stroke="#fff" stroke-width="3" opacity="0.6"/>
                                <text class="city-label" x="260" y="470" text-anchor="middle">جازان</text>
                            </g>
                        </svg>

                        <div class="branch-tooltip" id="branchTooltip">
                            <div class="fw-bold mb-1" id="tipCity"></div>
                            <div class="small">الإيرادات: <strong id="tipRevenue"></strong> ر</div>
                            <div class="small">الطلبات: <strong id="tipOrders"></strong></div>
                            <div class="small">الفروع: <strong id="tipBranches"></strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Cities Ranking --}}
        <div class="col-12 col-lg-4">
            <div class="widget-card h-100">
                <div class="widget-card__head"><h5>أعلى المدن مبيعاً</h5><p>ترتيب حسب الإيرادات</p></div>
                <div class="widget-card__body">
                    @php
                        $cities = [
                            ['الرياض', 45230, '#10b981'],
                            ['جدة', 38450, '#3b82f6'],
                            ['الدمّام', 32100, '#ef4444'],
                            ['مكة المكرّمة', 28900, '#8b5cf6'],
                            ['المدينة المنوّرة', 19800, '#f59e0b'],
                            ['بريدة', 13500, '#22c55e'],
                            ['تبوك', 11200, '#06b6d4'],
                            ['أبها', 9800, '#ec4899'],
                        ];
                        $maxRev = max(array_column($cities, 1));
                    @endphp
                    @foreach($cities as $i => $row)
                        @php [$city, $rev, $color] = $row; @endphp
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $color }}1a; color: {{ $color }}; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: .85rem; flex-shrink: 0;">
                                {{ $i + 1 }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold small">{{ $city }}</span>
                                    <span class="fw-bold small" style="color: {{ $color }}">{{ number_format($rev) }} ر</span>
                                </div>
                                <div class="progress" style="height: 5px; background: #f1f5f9;">
                                    <div class="progress-bar" style="width: {{ ($rev / $maxRev) * 100 }}%; background: {{ $color }};"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Branches Table --}}
    <div class="widget-card">
        <div class="widget-card__head">
            <h5>تفاصيل الفروع</h5>
            <p>قائمة شاملة لكلّ فرع</p>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless mb-0 align-middle">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th class="ps-4">الفرع</th>
                        <th>المدينة</th>
                        <th>المدير</th>
                        <th>الموظفين</th>
                        <th>الإيرادات</th>
                        <th>الطلبات</th>
                        <th class="pe-4">الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="ps-4 fw-bold">فرع الرياض - العليا</td><td>الرياض</td><td>عبدالله المحمد</td><td>5</td><td class="fw-bold text-success">25,400 ر</td><td>156</td><td class="pe-4"><span class="status-badge success">نشط</span></td></tr>
                    <tr><td class="ps-4 fw-bold">فرع الرياض - الملز</td><td>الرياض</td><td>سعد الفهد</td><td>4</td><td class="fw-bold text-success">12,830 ر</td><td>87</td><td class="pe-4"><span class="status-badge success">نشط</span></td></tr>
                    <tr><td class="ps-4 fw-bold">فرع الرياض - الصحافة</td><td>الرياض</td><td>ماجد السبيعي</td><td>4</td><td class="fw-bold text-success">7,000 ر</td><td>44</td><td class="pe-4"><span class="status-badge success">نشط</span></td></tr>
                    <tr><td class="ps-4 fw-bold">فرع جدة - الكورنيش</td><td>جدة</td><td>طارق الزهراني</td><td>6</td><td class="fw-bold text-success">22,100 ر</td><td>134</td><td class="pe-4"><span class="status-badge success">نشط</span></td></tr>
                    <tr><td class="ps-4 fw-bold">فرع جدة - السلامة</td><td>جدة</td><td>محمد العمري</td><td>3</td><td class="fw-bold text-success">16,350 ر</td><td>111</td><td class="pe-4"><span class="status-badge success">نشط</span></td></tr>
                    <tr><td class="ps-4 fw-bold">فرع الدمّام</td><td>الدمّام</td><td>فيصل القحطاني</td><td>4</td><td class="fw-bold text-success">18,900 ر</td><td>112</td><td class="pe-4"><span class="status-badge success">نشط</span></td></tr>
                    <tr><td class="ps-4 fw-bold">فرع الخبر</td><td>الدمّام</td><td>أحمد الشهري</td><td>4</td><td class="fw-bold text-success">13,200 ر</td><td>89</td><td class="pe-4"><span class="status-badge success">نشط</span></td></tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════════
     OTHER TABS (Placeholders — to be built in next phases)
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.2/dist/apexcharts.min.js"></script>
<script>
(function() {
    'use strict';

    // ═══ Tabs Switching ═══
    document.querySelectorAll('.dash-tabs button').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.dash-tabs button').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.getElementById('tab-' + this.dataset.tab).classList.add('active');
        });
    });

    // ═══ ApexCharts Common Options ═══
    const baseOpts = {
        chart: {
            fontFamily: 'Tajawal, sans-serif',
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        tooltip: { style: { fontFamily: 'Tajawal, sans-serif' } },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
    };

    // ═══ 1. Combined Trend (Revenue + Orders + Growth) ═══
    new ApexCharts(document.getElementById('combinedChart'), {
        series: [
            { name: 'الإيرادات', type: 'area', data: [4200, 5400, 4900, 6100, 5800, 7200, 8400] },
            { name: 'الطلبات', type: 'column', data: [12, 18, 15, 22, 19, 28, 32] },
            { name: 'النموّ %', type: 'line', data: [3.2, 5.1, -2.4, 7.8, -1.2, 9.5, 12.3] }
        ],
        chart: { ...baseOpts.chart, height: 340, type: 'line', stacked: false },
        stroke: { width: [2, 0, 3], curve: 'smooth', dashArray: [0, 0, 5] },
        plotOptions: { bar: { columnWidth: '40%', borderRadius: 5 } },
        fill: {
            type: ['gradient', 'solid', 'solid'],
            gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0, stops: [0, 90] }
        },
        colors: ['#7c3aed', '#10b981', '#ec4899'],
        dataLabels: { enabled: false },
        labels: ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'],
        xaxis: { categories: ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'] },
        yaxis: [
            { seriesName: 'الإيرادات', title: { text: 'الإيرادات (ر)', style: { fontFamily: 'Tajawal' } }, labels: { formatter: v => v.toLocaleString() } },
            { seriesName: 'الطلبات', opposite: true, title: { text: 'عدد الطلبات', style: { fontFamily: 'Tajawal' } } },
            { seriesName: 'النموّ %', show: false }
        ],
        legend: { position: 'bottom', horizontalAlign: 'center', fontFamily: 'Tajawal' },
        grid: baseOpts.grid,
        tooltip: baseOpts.tooltip
    }).render();

    // ═══ 2. Order Status Donut ═══
    new ApexCharts(document.getElementById('orderStatusChart'), {
        series: [22, 12, 4, 3],
        chart: { ...baseOpts.chart, type: 'donut', height: 280 },
        labels: ['مكتمل', 'قيد التحضير', 'جاهز', 'معلّق'],
        colors: ['#10b981', '#3b82f6', '#a855f7', '#f59e0b'],
        legend: { position: 'bottom', fontFamily: 'Tajawal' },
        dataLabels: { enabled: true, style: { fontFamily: 'Tajawal' } },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true, label: 'إجمالي',
                            fontFamily: 'Tajawal',
                            formatter: () => '41'
                        }
                    }
                }
            }
        }
    }).render();

    // ═══ 3. Order Types Stacked Bar ═══
    new ApexCharts(document.getElementById('orderTypesChart'), {
        series: [
            { name: 'مكتمل', data: [22, 8] },
            { name: 'قيد التحضير', data: [4, 7] }
        ],
        chart: { ...baseOpts.chart, type: 'bar', stacked: true, height: 280 },
        plotOptions: { bar: { horizontal: false, borderRadius: 4, columnWidth: '50%' } },
        xaxis: { categories: ['الكاشير', 'الواتس اب'] },
        colors: ['#10b981', '#f59e0b'],
        legend: { position: 'bottom', fontFamily: 'Tajawal' },
        dataLabels: { enabled: false },
        grid: baseOpts.grid,
        tooltip: baseOpts.tooltip
    }).render();

    // ═══ 4. Payment Methods Pie ═══
    new ApexCharts(document.getElementById('paymentMethodsChart'), {
        series: [38, 28, 18, 16],
        chart: { ...baseOpts.chart, type: 'pie', height: 280 },
        labels: ['مدى', 'نقدي', 'Apple Pay', 'تحويل'],
        colors: ['#10b981', '#f59e0b', '#3b82f6', '#a855f7'],
        legend: { position: 'bottom', fontFamily: 'Tajawal' },
        dataLabels: { style: { fontFamily: 'Tajawal' } }
    }).render();

    // ═══ 5. Daily Orders Bar ═══
    new ApexCharts(document.getElementById('dailyOrdersChart'), {
        series: [{ name: 'الطلبات', data: [12, 18, 15, 22, 19, 28, 32] }],
        chart: { ...baseOpts.chart, type: 'bar', height: 280 },
        plotOptions: { bar: { borderRadius: 7, columnWidth: '55%' } },
        xaxis: { categories: ['س', 'ح', 'ن', 'ث', 'ر', 'خ', 'ج'] },
        colors: ['#7c3aed'],
        dataLabels: { enabled: false },
        grid: baseOpts.grid,
        tooltip: baseOpts.tooltip
    }).render();

    // ═══ 6. Top 5 Products Horizontal ═══
    new ApexCharts(document.getElementById('top5ProductsChart'), {
        series: [{ name: 'مبيعات', data: [156, 124, 89, 67, 34] }],
        chart: { ...baseOpts.chart, type: 'bar', height: 280 },
        plotOptions: { bar: { horizontal: true, borderRadius: 5, barHeight: '70%' } },
        xaxis: { categories: ['قهوة عربيّة', 'لاتيه', 'برجر', 'بيتزا', 'سلطة'] },
        colors: ['#10b981'],
        dataLabels: { enabled: true, style: { fontFamily: 'Tajawal' } },
        grid: baseOpts.grid,
        tooltip: baseOpts.tooltip
    }).render();

    // ═══ 7. Orders by Payment Horizontal ═══
    new ApexCharts(document.getElementById('ordersByPaymentChart'), {
        series: [{ name: 'طلبات', data: [33, 24, 16, 14] }],
        chart: { ...baseOpts.chart, type: 'bar', height: 280 },
        plotOptions: { bar: { horizontal: true, borderRadius: 5, barHeight: '60%', distributed: true } },
        xaxis: { categories: ['مدى', 'نقدي', 'Apple Pay', 'تحويل'] },
        colors: ['#10b981', '#f59e0b', '#3b82f6', '#a855f7'],
        legend: { show: false },
        dataLabels: { enabled: false },
        grid: baseOpts.grid,
        tooltip: baseOpts.tooltip
    }).render();

    // ═══ 8. Revenue Distribution (Donut) ═══
    new ApexCharts(document.getElementById('revenueDistChart'), {
        series: [2728, 4005, 3685, 2808, 1190, 850],
        chart: { ...baseOpts.chart, type: 'donut', height: 320 },
        labels: ['لاتيه', 'برجر كلاسيك', 'بيتزا مارجريتا', 'قهوة عربيّة', 'سلطة سيزر', 'كنافة'],
        colors: ['#10b981', '#3b82f6', '#f59e0b', '#a855f7', '#ec4899', '#06b6d4'],
        legend: { position: 'bottom', fontFamily: 'Tajawal' },
        plotOptions: { pie: { donut: { size: '55%' } } },
        dataLabels: { style: { fontFamily: 'Tajawal' } }
    }).render();

    // ═══ 9. Avg Order Value (Area) ═══
    new ApexCharts(document.getElementById('avgOrderChart'), {
        series: [{ name: 'متوسط الفاتورة', data: [125, 130, 142, 138, 155, 148, 162] }],
        chart: { ...baseOpts.chart, type: 'area', height: 320 },
        stroke: { curve: 'smooth', width: 3 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0, stops: [0, 90] } },
        xaxis: { categories: ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'] },
        colors: ['#f59e0b'],
        dataLabels: { enabled: false },
        yaxis: { labels: { formatter: v => v + ' ر' } },
        grid: baseOpts.grid,
        tooltip: baseOpts.tooltip
    }).render();

    // ═══ 10. Revenue vs Expenses ═══
    new ApexCharts(document.getElementById('revVsExpChart'), {
        series: [
            { name: 'الإيرادات', data: [8200, 9400, 11800, 10500, 12100, 14250] },
            { name: 'المصاريف', data: [1800, 2100, 2300, 2050, 2200, 2340] }
        ],
        chart: { ...baseOpts.chart, type: 'bar', height: 280 },
        plotOptions: { bar: { borderRadius: 5, columnWidth: '50%' } },
        xaxis: { categories: ['ديسمبر', 'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو'] },
        colors: ['#10b981', '#ef4444'],
        dataLabels: { enabled: false },
        legend: { position: 'bottom', fontFamily: 'Tajawal' },
        yaxis: { labels: { formatter: v => v.toLocaleString() + ' ر' } },
        grid: baseOpts.grid,
        tooltip: baseOpts.tooltip
    }).render();

    // ═══ Saudi Map Tooltip ═══
    const tooltip = document.getElementById('branchTooltip');
    const wrap = document.getElementById('saudiMapWrap');
    if (tooltip && wrap) {
        document.querySelectorAll('.city-group').forEach(g => {
            g.addEventListener('mouseenter', () => {
                document.getElementById('tipCity').textContent = g.dataset.city;
                document.getElementById('tipRevenue').textContent = parseInt(g.dataset.revenue).toLocaleString('ar-SA');
                document.getElementById('tipOrders').textContent = g.dataset.orders;
                document.getElementById('tipBranches').textContent = g.dataset.branches > 0 ? g.dataset.branches : 'لا يوجد';
                tooltip.classList.add('show');
            });
            g.addEventListener('mousemove', e => {
                const rect = wrap.getBoundingClientRect();
                tooltip.style.left = (e.clientX - rect.left + 15) + 'px';
                tooltip.style.top = (e.clientY - rect.top + 15) + 'px';
            });
            g.addEventListener('mouseleave', () => tooltip.classList.remove('show'));
        });
    }
})();
</script>
@endpush
