@extends($activeTemplate . 'layouts.master')

@push('style')
<style>
    /* ════════════════════════════════════════════════════════
       Dashboard — Val POS / TwiqSoft
       تصميم احترافي مستوحى من دفترة + Zoho Books
       ──────────────────────────────────────────────────────── */
    :root {
        --d-primary: #4F46E5;
        --d-primary-light: #EEF2FF;
        --d-success: #10B981;
        --d-success-light: #ECFDF5;
        --d-warning: #F59E0B;
        --d-warning-light: #FEF3C7;
        --d-danger: #EF4444;
        --d-danger-light: #FEF2F2;
        --d-info: #3B82F6;
        --d-info-light: #EFF6FF;
        --d-purple: #8B5CF6;
        --d-purple-light: #F5F3FF;
        --d-pink: #EC4899;
        --d-pink-light: #FDF2F8;
        --d-text: #0F172A;
        --d-text-2: #475569;
        --d-text-3: #94A3B8;
        --d-bg: #F8FAFC;
        --d-border: #E2E8F0;
        --d-card: #FFFFFF;
    }

    .dash-wrap { padding: 6px 0; font-family: 'Cairo','Tajawal',sans-serif; direction: rtl; }

    /* ── Welcome Banner ── */
    .dash-welcome {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%);
        border-radius: 22px; padding: 28px 32px; color: white;
        position: relative; overflow: hidden; margin-bottom: 22px;
        box-shadow: 0 12px 35px rgba(79, 70, 229, 0.25);
    }
    .dash-welcome::before {
        content: ''; position: absolute; top: -40%; left: -10%;
        width: 380px; height: 380px;
        background: radial-gradient(circle, rgba(255,255,255,.18) 0%, transparent 70%);
    }
    .dash-welcome::after {
        content: ''; position: absolute; bottom: -50%; right: -8%;
        width: 320px; height: 320px;
        background: radial-gradient(circle, rgba(255,255,255,.12) 0%, transparent 70%);
    }
    .dash-welcome-content { position: relative; z-index: 2; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
    .dash-welcome h1 { font-size: 26px; font-weight: 900; margin: 0 0 8px; }
    .dash-welcome p { font-size: 15px; opacity: .92; margin: 0; }
    .dash-quick-actions { display: flex; gap: 10px; flex-wrap: wrap; }
    .dash-qa-btn {
        background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.25);
        color: white; padding: 11px 18px; border-radius: 12px; font-weight: 700;
        font-size: 13px; text-decoration: none; transition: all .2s;
        backdrop-filter: blur(10px); display: inline-flex; align-items: center; gap: 8px;
    }
    .dash-qa-btn:hover { background: rgba(255,255,255,.3); color: white; transform: translateY(-2px); }
    .dash-qa-btn i { font-size: 17px; }

    /* ── Smart Alerts Row ── */
    .dash-alerts { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 12px; margin-bottom: 22px; }
    .dash-alert { background: var(--d-card); border-radius: 14px; padding: 14px 16px; border-right: 4px solid; display: flex; gap: 12px; align-items: flex-start; box-shadow: 0 2px 8px rgba(0,0,0,.03); }
    .dash-alert--warning { border-color: var(--d-warning); }
    .dash-alert--success { border-color: var(--d-success); }
    .dash-alert--info { border-color: var(--d-info); }
    .dash-alert--danger { border-color: var(--d-danger); }
    .dash-alert-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 16px; }
    .dash-alert--warning .dash-alert-icon { background: var(--d-warning-light); color: var(--d-warning); }
    .dash-alert--success .dash-alert-icon { background: var(--d-success-light); color: var(--d-success); }
    .dash-alert--info    .dash-alert-icon { background: var(--d-info-light); color: var(--d-info); }
    .dash-alert--danger  .dash-alert-icon { background: var(--d-danger-light); color: var(--d-danger); }
    .dash-alert-body { flex: 1; min-width: 0; }
    .dash-alert-title { font-size: 13px; font-weight: 800; color: var(--d-text); margin-bottom: 2px; }
    .dash-alert-message { font-size: 12px; color: var(--d-text-2); }

    /* ── KPI Cards (Top stats) ── */
    .dash-kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 22px; }
    @media (max-width: 992px) { .dash-kpi-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .dash-kpi-grid { grid-template-columns: 1fr; } }
    .dash-kpi {
        background: var(--d-card); border-radius: 18px; padding: 20px;
        border: 1px solid var(--d-border); position: relative; overflow: hidden;
        transition: all .25s ease; box-shadow: 0 2px 6px rgba(0,0,0,.02);
    }
    .dash-kpi:hover { transform: translateY(-4px); box-shadow: 0 14px 30px rgba(0,0,0,.08); border-color: var(--c); }
    .dash-kpi::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 110px; height: 110px;
        background: radial-gradient(circle at top left, var(--c-light), transparent 70%);
        opacity: .65; pointer-events: none;
    }
    .dash-kpi[data-c="indigo"] { --c: #4F46E5; --c-light: #EEF2FF; }
    .dash-kpi[data-c="green"]  { --c: #10B981; --c-light: #ECFDF5; }
    .dash-kpi[data-c="blue"]   { --c: #3B82F6; --c-light: #EFF6FF; }
    .dash-kpi[data-c="purple"] { --c: #8B5CF6; --c-light: #F5F3FF; }
    .dash-kpi[data-c="amber"]  { --c: #F59E0B; --c-light: #FEF3C7; }
    .dash-kpi[data-c="pink"]   { --c: #EC4899; --c-light: #FDF2F8; }

    .dash-kpi-icon {
        width: 46px; height: 46px; border-radius: 12px;
        background: linear-gradient(135deg, var(--c), color-mix(in srgb, var(--c) 75%, black));
        color: white; display: flex; align-items: center; justify-content: center;
        font-size: 20px; box-shadow: 0 8px 14px color-mix(in srgb, var(--c) 35%, transparent);
        margin-bottom: 14px; position: relative; z-index: 1;
    }
    .dash-kpi-label { font-size: 12px; font-weight: 700; color: var(--d-text-3); letter-spacing: .3px; margin-bottom: 4px; }
    .dash-kpi-value { font-size: 28px; font-weight: 900; color: var(--d-text); line-height: 1; letter-spacing: -.5px; }
    .dash-kpi-unit { font-size: 13px; color: var(--d-text-3); font-weight: 600; margin-inline-start: 4px; }
    .dash-kpi-trend { margin-top: 10px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; }
    .dash-kpi-trend.up { color: var(--d-success); }
    .dash-kpi-trend.down { color: var(--d-danger); }
    .dash-kpi-trend.flat { color: var(--d-text-3); }

    /* ── Chart Cards ── */
    .dash-row { display: grid; grid-template-columns: 2fr 1fr; gap: 18px; margin-bottom: 22px; }
    @media (max-width: 992px) { .dash-row { grid-template-columns: 1fr; } }
    .dash-card { background: var(--d-card); border-radius: 18px; padding: 22px; border: 1px solid var(--d-border); }
    .dash-card-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; gap: 10px; flex-wrap: wrap; }
    .dash-card-title { font-size: 16px; font-weight: 800; color: var(--d-text); display: flex; align-items: center; gap: 8px; margin: 0; }
    .dash-card-title i { color: var(--d-primary); }
    .dash-card-subtitle { font-size: 12px; color: var(--d-text-3); font-weight: 600; }
    .dash-tab-pills { display: flex; gap: 4px; background: var(--d-bg); padding: 4px; border-radius: 10px; }
    .dash-tab-pill { padding: 6px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; color: var(--d-text-2); cursor: pointer; border: none; background: transparent; transition: all .15s; }
    .dash-tab-pill.active { background: var(--d-card); color: var(--d-primary); box-shadow: 0 1px 3px rgba(0,0,0,.05); }

    /* ── Quick Stats grid (small cards) ── */
    .dash-stats-row { display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px; margin-bottom: 22px; }
    @media (max-width: 1200px) { .dash-stats-row { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 600px)  { .dash-stats-row { grid-template-columns: repeat(2, 1fr); } }
    .dash-mini {
        background: var(--d-card); border-radius: 14px; padding: 16px 14px;
        border: 1px solid var(--d-border); transition: all .2s;
    }
    .dash-mini:hover { border-color: var(--d-primary); background: var(--d-primary-light); }
    .dash-mini-label { font-size: 11px; font-weight: 700; color: var(--d-text-3); margin-bottom: 6px; }
    .dash-mini-value { font-size: 19px; font-weight: 900; color: var(--d-text); line-height: 1; }
    .dash-mini-unit { font-size: 11px; color: var(--d-text-3); margin-inline-start: 2px; }

    /* ── Tables (Recent items) ── */
    .dash-table { width: 100%; }
    .dash-table th { font-size: 11px; font-weight: 800; color: var(--d-text-3); text-align: right; padding: 8px 12px; background: var(--d-bg); }
    .dash-table th:first-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }
    .dash-table th:last-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
    .dash-table td { padding: 12px; font-size: 13px; color: var(--d-text); border-bottom: 1px solid var(--d-border); }
    .dash-table tr:last-child td { border-bottom: none; }
    .dash-table-empty { padding: 40px 20px; text-align: center; color: var(--d-text-3); font-size: 13px; }
    .dash-table-empty i { font-size: 36px; display: block; margin-bottom: 8px; opacity: .35; }

    /* ── Top Products list ── */
    .dash-product-item { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid var(--d-border); }
    .dash-product-item:last-child { border-bottom: none; padding-bottom: 0; }
    .dash-product-rank { width: 28px; height: 28px; border-radius: 8px; background: var(--d-primary-light); color: var(--d-primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; flex-shrink: 0; }
    .dash-product-rank.gold   { background: linear-gradient(135deg, #FCD34D, #F59E0B); color: white; }
    .dash-product-rank.silver { background: linear-gradient(135deg, #E5E7EB, #9CA3AF); color: white; }
    .dash-product-rank.bronze { background: linear-gradient(135deg, #FCA5A5, #DC2626); color: white; }
    .dash-product-info { flex: 1; min-width: 0; }
    .dash-product-name { font-size: 13px; font-weight: 700; color: var(--d-text); margin: 0 0 4px; }
    .dash-product-bar { height: 6px; background: var(--d-bg); border-radius: 3px; overflow: hidden; }
    .dash-product-bar-fill { height: 100%; background: linear-gradient(90deg, var(--d-primary), var(--d-purple)); border-radius: 3px; }
    .dash-product-qty { font-size: 12px; font-weight: 800; color: var(--d-primary); flex-shrink: 0; }

    /* ── Status badges ── */
    .dash-badge { display: inline-block; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; }
    .dash-badge--success { background: var(--d-success-light); color: var(--d-success); }
    .dash-badge--warning { background: var(--d-warning-light); color: var(--d-warning); }
    .dash-badge--danger  { background: var(--d-danger-light); color: var(--d-danger); }
    .dash-badge--info    { background: var(--d-info-light); color: var(--d-info); }

    /* ── chart heights ── */
    #salesTrendChart   { min-height: 320px; }
    #paymentMethodChart{ min-height: 280px; }
</style>
@endpush

@section('panel')
<div class="dash-wrap">

    {{-- ════════ Welcome Banner ════════ --}}
    <div class="dash-welcome">
        <div class="dash-welcome-content">
            <div>
                <h1>
                    @lang('Welcome'), {{ auth()->user()->firstname ?? auth()->user()->username }} 👋
                </h1>
                <p>
                    {{ now()->locale(app()->getLocale())->translatedFormat('l، j F Y') }}
                    &nbsp;•&nbsp;
                    @lang('Quick overview of your business today')
                </p>
            </div>
            <div class="dash-quick-actions">
                <x-staff_permission_check permission="add sale">
                    <a href="{{ route('user.pos.index') }}" class="dash-qa-btn">
                        <i class="las la-cash-register"></i>
                        @lang('Start POS')
                    </a>
                </x-staff_permission_check>
                <x-staff_permission_check permission="add sale">
                    <a href="{{ route('user.sale.add') }}" class="dash-qa-btn">
                        <i class="las la-file-invoice"></i>
                        @lang('New Invoice')
                    </a>
                </x-staff_permission_check>
                <x-staff_permission_check permission="add customer">
                    <a href="{{ route('user.customer.list') }}" class="dash-qa-btn">
                        <i class="las la-user-plus"></i>
                        @lang('New Customer')
                    </a>
                </x-staff_permission_check>
                <x-staff_permission_check permission="add product">
                    <a href="{{ route('user.product.list') }}" class="dash-qa-btn">
                        <i class="las la-box"></i>
                        @lang('New Product')
                    </a>
                </x-staff_permission_check>
            </div>
        </div>
    </div>

    {{-- ════════ Smart Alerts ════════ --}}
    @if(!empty($smartAlerts) && count($smartAlerts) > 0)
        <div class="dash-alerts">
            @foreach($smartAlerts as $alert)
                <div class="dash-alert dash-alert--{{ $alert['type'] }}">
                    <div class="dash-alert-icon">
                        <i class="las {{ $alert['icon'] }}"></i>
                    </div>
                    <div class="dash-alert-body">
                        <div class="dash-alert-title">{{ $alert['title_ar'] }}</div>
                        <div class="dash-alert-message">{{ $alert['message_ar'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- ════════ KPI Cards (4 hero stats) ════════ --}}
    @php
        $todaySale     = (float)($widget['today_sale'] ?? 0);
        $yesterdaySale = (float)($widget['yesterday_sale'] ?? 0);
        $diffPct       = $yesterdaySale > 0 ? round((($todaySale - $yesterdaySale) / $yesterdaySale) * 100, 1) : 0;
        $todayExpense  = (float)($widget['today_expense'] ?? 0);
        $todayProfit   = $todaySale - $todayExpense;
        $todayOrders   = (int)($widget['today_orders_count'] ?? 0);
        $totalCustomers= (int)($widget['total_customers'] ?? 0);
    @endphp
    <div class="dash-kpi-grid">
        <div class="dash-kpi" data-c="indigo">
            <div class="dash-kpi-icon"><i class="las la-shopping-bag"></i></div>
            <div class="dash-kpi-label">@lang('Today Sales')</div>
            <div class="dash-kpi-value">
                {{ number_format($todaySale, 0) }}<span class="dash-kpi-unit">{{ $general->cur_text ?? 'ر.س' }}</span>
            </div>
            <div class="dash-kpi-trend {{ $diffPct > 0 ? 'up' : ($diffPct < 0 ? 'down' : 'flat') }}">
                <i class="las {{ $diffPct > 0 ? 'la-arrow-up' : ($diffPct < 0 ? 'la-arrow-down' : 'la-minus') }}"></i>
                {{ abs($diffPct) }}% @lang('vs yesterday')
            </div>
        </div>

        <div class="dash-kpi" data-c="green">
            <div class="dash-kpi-icon"><i class="las la-coins"></i></div>
            <div class="dash-kpi-label">@lang('Today Profit')</div>
            <div class="dash-kpi-value">
                {{ number_format($todayProfit, 0) }}<span class="dash-kpi-unit">{{ $general->cur_text ?? 'ر.س' }}</span>
            </div>
            <div class="dash-kpi-trend flat">
                <i class="las la-receipt"></i> @lang('After') {{ number_format($todayExpense, 0) }} @lang('expenses')
            </div>
        </div>

        <div class="dash-kpi" data-c="blue">
            <div class="dash-kpi-icon"><i class="las la-file-invoice"></i></div>
            <div class="dash-kpi-label">@lang('Today Invoices')</div>
            <div class="dash-kpi-value">{{ $todayOrders }}</div>
            <div class="dash-kpi-trend flat">
                <i class="las la-clock"></i>
                @lang('Avg') {{ number_format((float)($widget['today_avg_order'] ?? 0), 0) }} {{ $general->cur_text ?? 'ر.س' }}
            </div>
        </div>

        <div class="dash-kpi" data-c="purple">
            <div class="dash-kpi-icon"><i class="las la-users"></i></div>
            <div class="dash-kpi-label">@lang('Customers')</div>
            <div class="dash-kpi-value">{{ $totalCustomers }}</div>
            <div class="dash-kpi-trend up">
                <i class="las la-user-plus"></i>
                +{{ $widget['new_customers_month'] ?? 0 }} @lang('this month')
            </div>
        </div>
    </div>

    {{-- ════════ Sales Trend Chart + Payment Methods Donut ════════ --}}
    <div class="dash-row">
        <div class="dash-card">
            <div class="dash-card-head">
                <div>
                    <h6 class="dash-card-title">
                        <i class="las la-chart-area"></i>
                        @lang('Sales Trend')
                    </h6>
                    <div class="dash-card-subtitle">@lang('Last 7 days')</div>
                </div>
                <div class="dash-tab-pills">
                    <button class="dash-tab-pill active" data-series="all">@lang('All')</button>
                    <button class="dash-tab-pill" data-series="sales">@lang('Sales')</button>
                    <button class="dash-tab-pill" data-series="expenses">@lang('Expenses')</button>
                </div>
            </div>
            <div id="salesTrendChart"></div>
        </div>

        <div class="dash-card">
            <div class="dash-card-head">
                <div>
                    <h6 class="dash-card-title">
                        <i class="las la-credit-card"></i>
                        @lang('Payment Methods')
                    </h6>
                    <div class="dash-card-subtitle">@lang('Last 30 days')</div>
                </div>
            </div>
            <div id="paymentMethodChart"></div>
        </div>
    </div>

    {{-- ════════ Quick Stats — 6 mini cards ════════ --}}
    <div class="dash-stats-row">
        <div class="dash-mini">
            <div class="dash-mini-label">@lang('This Week Sales')</div>
            <div class="dash-mini-value">{{ number_format((float)($widget['this_week_sale'] ?? 0), 0) }}<span class="dash-mini-unit">{{ $general->cur_text ?? 'ر.س' }}</span></div>
        </div>
        <div class="dash-mini">
            <div class="dash-mini-label">@lang('This Month Sales')</div>
            <div class="dash-mini-value">{{ number_format((float)($widget['this_month_sale'] ?? 0), 0) }}<span class="dash-mini-unit">{{ $general->cur_text ?? 'ر.س' }}</span></div>
        </div>
        <div class="dash-mini">
            <div class="dash-mini-label">@lang('This Month Expenses')</div>
            <div class="dash-mini-value">{{ number_format((float)($widget['this_month_expense'] ?? 0), 0) }}<span class="dash-mini-unit">{{ $general->cur_text ?? 'ر.س' }}</span></div>
        </div>
        <div class="dash-mini">
            <div class="dash-mini-label">@lang('This Month Purchases')</div>
            <div class="dash-mini-value">{{ number_format((float)($widget['this_month_purchase'] ?? 0), 0) }}<span class="dash-mini-unit">{{ $general->cur_text ?? 'ر.س' }}</span></div>
        </div>
        <div class="dash-mini">
            <div class="dash-mini-label">@lang('Low Stock Items')</div>
            <div class="dash-mini-value" style="color: {{ ($widget['low_stock_count'] ?? 0) > 0 ? 'var(--d-warning)' : 'var(--d-text)' }};">
                {{ $widget['low_stock_count'] ?? 0 }}
            </div>
        </div>
        <div class="dash-mini">
            <div class="dash-mini-label">@lang('Active Customers')</div>
            <div class="dash-mini-value">{{ $widget['active_customers'] ?? 0 }}</div>
        </div>
    </div>

    {{-- ════════ Top Products + Recent Sales ════════ --}}
    <div class="dash-row">
        <div class="dash-card">
            <div class="dash-card-head">
                <div>
                    <h6 class="dash-card-title">
                        <i class="las la-clock"></i>
                        @lang('Recent Sales')
                    </h6>
                    <div class="dash-card-subtitle">@lang('Last 5 invoices')</div>
                </div>
                <a href="{{ route('user.sale.list') }}" class="dash-badge dash-badge--info" style="text-decoration: none;">
                    @lang('View all') <i class="las la-angle-left"></i>
                </a>
            </div>

            @if(isset($recentSales) && $recentSales->count() > 0)
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>@lang('Invoice')</th>
                            <th>@lang('Customer')</th>
                            <th>@lang('Total')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentSales as $sale)
                            <tr>
                                <td><strong>#{{ $sale->invoice_no ?? $sale->id }}</strong></td>
                                <td>{{ $sale->customer->name ?? '—' }}</td>
                                <td style="color: var(--d-success); font-weight: 800;">
                                    {{ number_format($sale->total ?? 0, 2) }} {{ $general->cur_text ?? 'ر.س' }}
                                </td>
                                <td>
                                    @php
                                        $due = ($sale->total ?? 0) - ($sale->paid ?? 0);
                                        $statusClass = $due <= 0 ? 'success' : ($due == $sale->total ? 'danger' : 'warning');
                                        $statusText  = $due <= 0 ? 'مدفوعة' : ($due == $sale->total ? 'غير مدفوعة' : 'جزئي');
                                    @endphp
                                    <span class="dash-badge dash-badge--{{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td style="color: var(--d-text-3); font-size: 12px;">
                                    {{ \Carbon\Carbon::parse($sale->sale_date ?? $sale->created_at)->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="dash-table-empty">
                    <i class="las la-inbox"></i>
                    @lang('No sales yet')
                </div>
            @endif
        </div>

        <div class="dash-card">
            <div class="dash-card-head">
                <div>
                    <h6 class="dash-card-title">
                        <i class="las la-trophy"></i>
                        @lang('Top Products')
                    </h6>
                    <div class="dash-card-subtitle">@lang('Best sellers')</div>
                </div>
            </div>

            @if(isset($topSellingProducts) && $topSellingProducts->count() > 0)
                @php
                    $maxQty = $topSellingProducts->max('total_quantity') ?: 1;
                    $rankClasses = ['gold', 'silver', 'bronze', '', ''];
                @endphp
                @foreach($topSellingProducts as $i => $product)
                    @php $pct = ($product->total_quantity / $maxQty) * 100; @endphp
                    <div class="dash-product-item">
                        <div class="dash-product-rank {{ $rankClasses[$i] ?? '' }}">{{ $i + 1 }}</div>
                        <div class="dash-product-info">
                            <p class="dash-product-name">
                                {{ $product->productDetail->product->name ?? '—' }}
                            </p>
                            <div class="dash-product-bar">
                                <div class="dash-product-bar-fill" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                        <span class="dash-product-qty">{{ (int)$product->total_quantity }}</span>
                    </div>
                @endforeach
            @else
                <div class="dash-table-empty">
                    <i class="las la-box-open"></i>
                    @lang('No product sales data')
                </div>
            @endif
        </div>
    </div>

    {{-- ════════ Recent Purchases + Recent Customers ════════ --}}
    <div class="dash-row">
        <div class="dash-card">
            <div class="dash-card-head">
                <div>
                    <h6 class="dash-card-title">
                        <i class="las la-truck-loading"></i>
                        @lang('Recent Purchases')
                    </h6>
                </div>
                <a href="{{ route('user.purchase.list') }}" class="dash-badge dash-badge--info" style="text-decoration: none;">
                    @lang('View all') <i class="las la-angle-left"></i>
                </a>
            </div>
            @if(isset($recentPurchases) && $recentPurchases->count() > 0)
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('Supplier')</th>
                            <th>@lang('Total')</th>
                            <th>@lang('Date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPurchases as $purchase)
                            <tr>
                                <td><strong>#{{ $purchase->invoice_no ?? $purchase->id }}</strong></td>
                                <td>{{ $purchase->supplier->name ?? '—' }}</td>
                                <td style="font-weight: 800;">
                                    {{ number_format($purchase->total ?? 0, 2) }} {{ $general->cur_text ?? 'ر.س' }}
                                </td>
                                <td style="color: var(--d-text-3); font-size: 12px;">
                                    {{ \Carbon\Carbon::parse($purchase->purchase_date ?? $purchase->created_at)->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="dash-table-empty">
                    <i class="las la-inbox"></i>
                    @lang('No purchases yet')
                </div>
            @endif
        </div>

        <div class="dash-card">
            <div class="dash-card-head">
                <div>
                    <h6 class="dash-card-title">
                        <i class="las la-warehouse"></i>
                        @lang('Warehouses')
                    </h6>
                </div>
            </div>
            @if(isset($warehouses) && $warehouses->count() > 0)
                @foreach($warehouses as $wh)
                    <div class="dash-product-item">
                        <div class="dash-product-rank">
                            <i class="las la-store" style="font-size: 14px;"></i>
                        </div>
                        <div class="dash-product-info">
                            <p class="dash-product-name">{{ $wh->name }}</p>
                            <div style="font-size: 11px; color: var(--d-text-3);">
                                {{ $wh->address ?? __('No address') }}
                            </div>
                        </div>
                        @if($wh->status)
                            <span class="dash-badge dash-badge--success">@lang('Active')</span>
                        @else
                            <span class="dash-badge dash-badge--danger">@lang('Inactive')</span>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="dash-table-empty">
                    <i class="las la-warehouse"></i>
                    @lang('No warehouses yet')
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('script-lib')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.0/dist/apexcharts.min.js"></script>
@endpush

@push('script')
<script>
    (function() {
        'use strict';

        // ─── Data from PHP ───
        const chartData = @json($chartData ?? ['weekly' => ['labels' => [], 'sales' => [], 'expenses' => [], 'profit' => []], 'paymentMethods' => [], 'orderTypes' => ['pos' => 0, 'whatsapp' => 0]]);

        const isRtl = document.documentElement.getAttribute('dir') === 'rtl'
                   || document.body.dir === 'rtl'
                   || true; // default to RTL since we know it's Arabic

        // ═══════════════════════════════════════════════════
        // CHART 1: Sales Trend (Area Chart - last 7 days)
        // ═══════════════════════════════════════════════════
        const salesChartOptions = {
            chart: {
                type: 'area',
                height: 320,
                toolbar: { show: false },
                fontFamily: 'Cairo, Tajawal, sans-serif',
                background: 'transparent',
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            series: [
                { name: 'المبيعات', data: chartData.weekly.sales || [] },
                { name: 'المصاريف', data: chartData.weekly.expenses || [] },
                { name: 'الأرباح',  data: chartData.weekly.profit  || [] }
            ],
            xaxis: {
                categories: chartData.weekly.labels || [],
                labels: { style: { fontSize: '12px', fontWeight: 600, colors: '#94A3B8' } },
                axisBorder: { show: false }, axisTicks: { show: false }
            },
            yaxis: {
                opposite: isRtl,
                labels: {
                    style: { fontSize: '12px', colors: '#94A3B8' },
                    formatter: v => Math.round(v).toLocaleString('ar-SA')
                }
            },
            colors: ['#4F46E5', '#EF4444', '#10B981'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },
            stroke: { curve: 'smooth', width: 3 },
            grid: { borderColor: '#E2E8F0', strokeDashArray: 4, padding: { right: 10 } },
            legend: {
                position: 'top', horizontalAlign: 'right',
                fontSize: '13px', fontWeight: 700, fontFamily: 'Cairo, sans-serif',
                markers: { width: 12, height: 12, radius: 6 }
            },
            tooltip: {
                style: { fontSize: '13px', fontFamily: 'Cairo, sans-serif' },
                y: { formatter: v => Math.round(v).toLocaleString('ar-SA') + ' ر.س' }
            },
            dataLabels: { enabled: false }
        };

        const salesChart = new ApexCharts(document.querySelector('#salesTrendChart'), salesChartOptions);
        salesChart.render();

        // ─ Tab switching for the chart ─
        document.querySelectorAll('.dash-tab-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.dash-tab-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');

                const series = this.dataset.series;
                if (series === 'all') {
                    salesChart.updateSeries([
                        { name: 'المبيعات', data: chartData.weekly.sales || [] },
                        { name: 'المصاريف', data: chartData.weekly.expenses || [] },
                        { name: 'الأرباح',  data: chartData.weekly.profit  || [] }
                    ]);
                } else if (series === 'sales') {
                    salesChart.updateSeries([{ name: 'المبيعات', data: chartData.weekly.sales || [] }]);
                } else if (series === 'expenses') {
                    salesChart.updateSeries([{ name: 'المصاريف', data: chartData.weekly.expenses || [] }]);
                }
            });
        });

        // ═══════════════════════════════════════════════════
        // CHART 2: Payment Methods Donut (last 30 days)
        // ═══════════════════════════════════════════════════
        const pmData = chartData.paymentMethods || [];
        const pmLabels = pmData.length > 0 ? pmData.map(p => p.name) : ['لا توجد بيانات'];
        const pmValues = pmData.length > 0 ? pmData.map(p => parseFloat(p.total) || 0) : [1];

        const paymentOptions = {
            chart: {
                type: 'donut',
                height: 280,
                fontFamily: 'Cairo, Tajawal, sans-serif',
                background: 'transparent'
            },
            series: pmValues,
            labels: pmLabels,
            colors: ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#3B82F6', '#EC4899'],
            stroke: { width: 3, colors: ['#FFFFFF'] },
            dataLabels: {
                enabled: true,
                formatter: (val) => Math.round(val) + '%',
                style: { fontSize: '12px', fontWeight: 700, fontFamily: 'Cairo, sans-serif' }
            },
            legend: {
                position: 'bottom',
                fontSize: '12px', fontWeight: 600, fontFamily: 'Cairo, sans-serif',
                markers: { width: 10, height: 10, radius: 5 }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '68%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'الإجمالي',
                                fontSize: '13px', fontWeight: 700, color: '#94A3B8',
                                formatter: (w) => {
                                    const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return Math.round(total).toLocaleString('ar-SA') + ' ر.س';
                                }
                            },
                            value: {
                                fontSize: '20px', fontWeight: 900, color: '#0F172A',
                                fontFamily: 'Cairo, sans-serif',
                                formatter: (val) => Math.round(val).toLocaleString('ar-SA')
                            }
                        }
                    }
                }
            },
            tooltip: {
                y: { formatter: v => Math.round(v).toLocaleString('ar-SA') + ' ر.س' }
            }
        };

        const paymentChart = new ApexCharts(document.querySelector('#paymentMethodChart'), paymentOptions);
        paymentChart.render();

    })();
</script>
@endpush
