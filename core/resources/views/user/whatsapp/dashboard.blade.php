@extends($activeTemplate . 'layouts.master')

@push('style')
<style>
.wa-tabs{display:flex;gap:0;border-bottom:2px solid #e5e7eb;overflow-x:auto}
.wa-tabs a{padding:.75rem 1.25rem;font-weight:600;font-size:.875rem;color:#64748b;border-bottom:2px solid transparent;margin-bottom:-2px;white-space:nowrap;text-decoration:none;display:flex;align-items:center;gap:.4rem}
.wa-tabs a:hover{color:#0f172a}
.wa-tabs a.active{color:#059669;border-color:#10b981}
.wa-stat{background:#fff;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem}
.wa-stat .label{font-size:.75rem;color:#64748b;font-weight:600;text-transform:uppercase}
.wa-stat .value{font-size:1.75rem;font-weight:700;color:#0f172a;margin:.5rem 0 .25rem}
.wa-stat .meta{font-size:.75rem;color:#64748b}
</style>
@endpush

@section('panel')
@include('user.whatsapp.partials._tabs')

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="wa-stat">
            <div class="d-flex justify-content-between align-items-start">
                <span class="label">طلبات اليوم</span>
                <i class="las la-shopping-bag fs-5 text-muted"></i>
            </div>
            <div class="value">{{ $stats['today_orders'] ?? 0 }}</div>
            <div class="meta">من الواتس اب</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="wa-stat">
            <div class="d-flex justify-content-between align-items-start">
                <span class="label">طلبات معلّقة</span>
                <i class="las la-clock fs-5 text-muted"></i>
            </div>
            <div class="value text-warning">{{ $stats['pending_orders'] ?? 0 }}</div>
            <div class="meta">بحاجة لتأكيد</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="wa-stat">
            <div class="d-flex justify-content-between align-items-start">
                <span class="label">إيرادات اليوم</span>
                <i class="las la-coins fs-5 text-muted"></i>
            </div>
            <div class="value">{{ number_format($stats['today_revenue'] ?? 0, 0) }} ر</div>
            <div class="meta text-success">من الواتس اب فقط</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="wa-stat">
            <div class="d-flex justify-content-between align-items-start">
                <span class="label">العملاء النشطون</span>
                <i class="las la-users fs-5 text-muted"></i>
            </div>
            <div class="value">{{ $stats['active_customers'] ?? 0 }}</div>
            <div class="meta">آخر 30 يوم</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 d-flex align-items-center gap-2">
            <span class="d-inline-block bg-success rounded-circle" style="width:8px;height:8px;animation:pulse 2s infinite"></span>
            الطلبات اللحظيّة
        </h5>
        <a href="{{ route('user.whatsapp.orders.index') }}" class="text-success small fw-bold text-decoration-none">عرض الكلّ ←</a>
    </div>
    <div class="card-body p-0">
        @forelse($recentOrders ?? [] as $order)
            @php
                $sb = ['pending'=>['جديد','warning'],'preparing'=>['قيد التجهيز','primary'],'ready'=>['جاهز','info'],'completed'=>['مكتمل','success'],'cancelled'=>['ملغى','danger']][$order->status ?? 'pending'] ?? ['جديد','warning'];
            @endphp
            <div class="d-flex align-items-center p-3 border-bottom">
                <span class="badge bg-{{ $sb[1] }} me-3">{{ $sb[0] }}</span>
                <div class="flex-grow-1">
                    <strong>{{ $order->customer_name ?? '-' }}</strong>
                    <small class="text-muted ms-2">#{{ $order->order_number ?? $order->id }}</small>
                    <div class="small text-muted mt-1">
                        <i class="las la-phone"></i> {{ $order->customer_phone ?? '-' }}
                        <span class="ms-3">{{ optional($order->created_at)->diffForHumans() }}</span>
                    </div>
                </div>
                <strong class="text-success me-3">{{ number_format($order->total ?? 0, 0) }} ر</strong>
                <a href="{{ route('user.whatsapp.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">عرض</a>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="las la-inbox" style="font-size:3rem;color:#cbd5e1"></i>
                <p class="text-muted mt-2 mb-3">لا توجد طلبات بعد</p>
                @if(!$isConnected)
                    <a href="{{ route('user.whatsapp.connect.show') }}" class="btn btn-success">
                        <i class="lab la-whatsapp"></i> اربط حساب الواتس اب
                    </a>
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection
