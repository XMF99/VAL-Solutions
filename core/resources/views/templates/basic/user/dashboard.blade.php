@extends($activeTemplate . 'layouts.master')

@section('panel')
<div style="padding: 2rem; font-family: 'Tajawal', sans-serif;" dir="rtl">
    <h1 style="color: #10b981;">مرحباً، {{ auth()->user()->firstname ?? 'مستخدم' }} {{ auth()->user()->lastname ?? '' }}</h1>
    <p style="color: #64748b;">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</p>

    <div class="row g-3 mt-3">
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted small">إيرادات اليوم</h6>
                    <h3 style="color: #10b981;">{{ number_format((float)($widget['today_sale'] ?? 0), 0) }} ر.س</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted small">المصاريف</h6>
                    <h3 style="color: #ef4444;">{{ number_format((float)($widget['today_expense'] ?? 0), 0) }} ر.س</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted small">الفواتير اليوم</h6>
                    <h3 style="color: #3b82f6;">{{ $widget['today_orders_count'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted small">إجمالي العملاء</h6>
                    <h3 style="color: #8b5cf6;">{{ $widget['total_customers'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="m-0">أحدث الفواتير</h5>
        </div>
        <div class="card-body p-0">
            @if(isset($recentSales) && count($recentSales) > 0)
                <table class="table mb-0">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th>الرقم</th>
                            <th>العميل</th>
                            <th>الإجمالي</th>
                            <th>الوقت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentSales as $sale)
                            <tr>
                                <td><strong>#{{ $sale->id }}</strong></td>
                                <td>{{ $sale->customer->name ?? 'عميل غير محدّد' }}</td>
                                <td style="color: #10b981;"><strong>{{ number_format($sale->total ?? 0, 2) }} ر</strong></td>
                                <td class="text-muted small">{{ $sale->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-muted py-4 m-0">لا توجد فواتير بعد</p>
            @endif
        </div>
    </div>

    <div class="alert alert-info mt-4">
        <strong>Dashboard شغّال بنجاح</strong>
        <p class="mb-0 small">الـcharts المتقدّمة ستتفعّل لاحقاً.</p>
    </div>
</div>
@endsection
