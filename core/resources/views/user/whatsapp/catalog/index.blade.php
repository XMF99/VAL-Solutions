@extends($activeTemplate . 'layouts.master')
@push('style')<style>.wa-tabs{display:flex;gap:0;border-bottom:2px solid #e5e7eb;overflow-x:auto}.wa-tabs a{padding:.75rem 1.25rem;font-weight:600;font-size:.875rem;color:#64748b;border-bottom:2px solid transparent;margin-bottom:-2px;text-decoration:none;display:flex;align-items:center;gap:.4rem}.wa-tabs a.active{color:#059669;border-color:#10b981}.toggle-switch{position:relative;width:44px;height:24px;border-radius:12px;cursor:pointer;border:none}.toggle-switch.on{background:#10b981}.toggle-switch.off{background:#cbd5e1}.toggle-switch span{position:absolute;top:2px;width:20px;height:20px;background:#fff;border-radius:50%;transition:.2s}.toggle-switch.on span{right:2px}.toggle-switch.off span{right:22px}</style>@endpush
@section('panel')
@include('user.whatsapp.partials._tabs')
<div class="alert alert-info d-flex align-items-start gap-3">
    <i class="las la-info-circle fs-4"></i>
    <div class="flex-grow-1">
        <strong>المنتجات المنشورة على الواتس اب</strong>
        <div class="small">المنتجات اللي تختارها هنا ستظهر للعملاء في الكاتالوج عند طلبهم القائمة.</div>
    </div>
    <form method="POST" action="{{ route('user.whatsapp.catalog.sync') }}">@csrf
        <button class="btn btn-info text-white"><i class="las la-bolt"></i> مزامنة Meta</button>
    </form>
</div>
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between">
        <h6 class="mb-0">{{ $publishedCount ?? 0 }} من {{ $totalProducts ?? 0 }} منتج منشور</h6>
    </div>
    <div class="card-body p-0">
        @forelse($products ?? [] as $p)
            <div class="d-flex align-items-center p-3 border-bottom">
                <div class="rounded bg-light d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;font-size:1.5rem">📦</div>
                <div class="flex-grow-1">
                    <strong>{{ $p->name ?? '-' }}</strong>
                    <div class="small text-muted">{{ number_format($p->price ?? 0, 0) }} ر</div>
                </div>
                <form method="POST" action="{{ route('user.whatsapp.catalog.toggle', $p->id) }}">@csrf
                    <button type="submit" class="toggle-switch {{ ($p->is_published ?? false) ? 'on' : 'off' }}"><span></span></button>
                </form>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="las la-box-open fs-1" style="color:#cbd5e1"></i>
                <p class="mt-2 mb-0">ما عندك منتجات بعد. أضفها من إدارة المنتج في الكاشير.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
