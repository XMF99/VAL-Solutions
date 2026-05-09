@php $cr = request()->route()->getName() ?? ''; @endphp

@if(!($isConnected ?? false))
<div class="alert alert-warning d-flex align-items-center mb-3">
    <i class="lab la-whatsapp me-2 fs-4"></i>
    <span class="flex-grow-1">حساب الواتس اب غير مربوط بعد. اربطه لتبدأ باستلام الطلبات.</span>
    <a href="{{ route('user.whatsapp.connect.show') }}" class="btn btn-sm btn-warning fw-bold">ربط الآن</a>
</div>
@else
<div class="alert alert-success d-flex align-items-center mb-3">
    <i class="las la-check-circle me-2 fs-4"></i>
    <span class="flex-grow-1">حساب مربوط: <strong>{{ $setting->whatsapp_number ?? '-' }}</strong></span>
    <span class="badge bg-success">نشط</span>
</div>
@endif

<div class="wa-tabs mb-4">
    <a href="{{ route('user.whatsapp.dashboard') }}" class="{{ $cr === 'user.whatsapp.dashboard' ? 'active' : '' }}">
        <i class="las la-tachometer-alt"></i> نظرة عامّة
    </a>
    <a href="{{ route('user.whatsapp.orders.index') }}" class="{{ str_starts_with($cr, 'user.whatsapp.orders') ? 'active' : '' }}">
        <i class="las la-shopping-bag"></i> الطلبات
    </a>
    <a href="{{ route('user.whatsapp.catalog.index') }}" class="{{ str_starts_with($cr, 'user.whatsapp.catalog') ? 'active' : '' }}">
        <i class="las la-boxes"></i> الكاتالوج
    </a>
    <a href="{{ route('user.whatsapp.settings.edit') }}" class="{{ str_starts_with($cr, 'user.whatsapp.settings') ? 'active' : '' }}">
        <i class="las la-cog"></i> الإعدادات
    </a>
    <a href="{{ route('user.whatsapp.connect.show') }}" class="{{ str_starts_with($cr, 'user.whatsapp.connect') ? 'active' : '' }}">
        <i class="lab la-whatsapp"></i> ربط الواتس اب
    </a>
</div>
