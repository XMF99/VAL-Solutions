@extends($activeTemplate . 'layouts.master')

@push('style')
<style>
.wa-tabs{display:flex;gap:0;border-bottom:2px solid #e5e7eb;overflow-x:auto}
.wa-tabs a{padding:.75rem 1.25rem;font-weight:600;font-size:.875rem;color:#64748b;border-bottom:2px solid transparent;margin-bottom:-2px;white-space:nowrap;text-decoration:none;display:flex;align-items:center;gap:.4rem}
.wa-tabs a:hover{color:#0f172a}
.wa-tabs a.active{color:#059669;border-color:#10b981}
</style>
@endpush

@section('panel')
@include('user.whatsapp.partials._tabs')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">جميع طلبات الواتس اب</h5>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th>الحالة</th>
                    <th>رقم الطلب</th>
                    <th>العميل</th>
                    <th>الجوّال</th>
                    <th>الإجمالي</th>
                    <th>الوقت</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders ?? [] as $order)
                    @php
                        $sb = ['pending'=>['جديد','warning'],'preparing'=>['قيد التجهيز','primary'],'ready'=>['جاهز','info'],'completed'=>['مكتمل','success'],'cancelled'=>['ملغى','danger']][$order->status ?? 'pending'] ?? ['جديد','warning'];
                    @endphp
                    <tr>
                        <td><span class="badge bg-{{ $sb[1] }}">{{ $sb[0] }}</span></td>
                        <td><strong>#{{ $order->order_number ?? $order->id }}</strong></td>
                        <td>{{ $order->customer_name ?? '-' }}</td>
                        <td class="text-muted">{{ $order->customer_phone ?? '-' }}</td>
                        <td class="fw-bold text-success">{{ number_format($order->total ?? 0, 0) }} ر</td>
                        <td class="small text-muted">{{ optional($order->created_at)->diffForHumans() }}</td>
                        <td><a href="{{ route('user.whatsapp.orders.show', $order->id) }}" class="btn btn-sm btn-outline-success"><i class="las la-eye"></i> عرض</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="las la-inbox fs-1" style="color:#cbd5e1"></i>
                            <p class="mt-2 mb-0">لا توجد طلبات بعد</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($orders) && method_exists($orders, 'links'))
        <div class="card-footer bg-white">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
