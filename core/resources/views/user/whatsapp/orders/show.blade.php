@extends($activeTemplate . 'layouts.master')
@push('style')<style>.wa-tabs{display:flex;gap:0;border-bottom:2px solid #e5e7eb;overflow-x:auto}.wa-tabs a{padding:.75rem 1.25rem;font-weight:600;font-size:.875rem;color:#64748b;border-bottom:2px solid transparent;margin-bottom:-2px;text-decoration:none;display:flex;align-items:center;gap:.4rem}.wa-tabs a.active{color:#059669;border-color:#10b981}</style>@endpush
@section('panel')
@include('user.whatsapp.partials._tabs')
<div class="card">
    <div class="card-header bg-white"><h5 class="mb-0">تفاصيل الطلب #{{ $order->order_number ?? $order->id }}</h5></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <h6 class="fw-bold">معلومات العميل</h6>
                <p class="mb-1"><strong>الاسم:</strong> {{ $order->customer_name ?? '-' }}</p>
                <p class="mb-1"><strong>الجوّال:</strong> {{ $order->customer_phone ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold">تفاصيل الطلب</h6>
                <p class="mb-1"><strong>الحالة:</strong> {{ $order->status ?? '-' }}</p>
                <p class="mb-1"><strong>الإجمالي:</strong> <span class="text-success fw-bold">{{ number_format($order->total ?? 0, 2) }} ر</span></p>
            </div>
        </div>
        <hr>
        <div class="d-flex gap-2 flex-wrap">
            @if(($order->status ?? '') === 'pending')
                <form method="POST" action="{{ route('user.whatsapp.orders.confirm', $order->id) }}">@csrf<button class="btn btn-success">تأكيد</button></form>
                <form method="POST" action="{{ route('user.whatsapp.orders.cancel', $order->id) }}">@csrf<button class="btn btn-danger">إلغاء</button></form>
            @endif
            <form method="POST" action="{{ route('user.whatsapp.orders.convert', $order->id) }}">@csrf<button class="btn btn-primary">تحويل لـ POS</button></form>
        </div>
    </div>
</div>
@endsection
