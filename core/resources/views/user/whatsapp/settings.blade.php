@extends($activeTemplate . 'layouts.master')
@push('style')<style>.wa-tabs{display:flex;gap:0;border-bottom:2px solid #e5e7eb;overflow-x:auto}.wa-tabs a{padding:.75rem 1.25rem;font-weight:600;font-size:.875rem;color:#64748b;border-bottom:2px solid transparent;margin-bottom:-2px;text-decoration:none;display:flex;align-items:center;gap:.4rem}.wa-tabs a.active{color:#059669;border-color:#10b981}</style>@endpush
@section('panel')
@include('user.whatsapp.partials._tabs')
<form method="POST" action="{{ route('user.whatsapp.settings.update') }}">@csrf
    <div class="card mb-3">
        <div class="card-header bg-white"><h6 class="mb-0">معلومات المتجر</h6></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-bold">اسم المتجر</label><input name="store_name" value="{{ old('store_name', $setting->store_name ?? '') }}" class="form-control"></div>
                <div class="col-md-6"><label class="form-label fw-bold">رابط (slug)</label><input name="store_slug" value="{{ old('store_slug', $setting->store_slug ?? '') }}" class="form-control"></div>
                <div class="col-12"><label class="form-label fw-bold">رسالة الترحيب</label><textarea name="welcome_message" rows="3" class="form-control">{{ old('welcome_message', $setting->welcome_message ?? '') }}</textarea></div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-white"><h6 class="mb-0">سياسة الطلب</h6></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-bold">الحدّ الأدنى للطلب (ر)</label><input type="number" name="min_order_amount" value="{{ old('min_order_amount', $setting->min_order_amount ?? 0) }}" class="form-control"></div>
                <div class="col-md-6"><label class="form-label fw-bold">رسوم التوصيل (ر)</label><input type="number" name="delivery_fee" value="{{ old('delivery_fee', $setting->delivery_fee ?? 0) }}" class="form-control"></div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-white"><h6 class="mb-0">طرق الدفع المقبولة</h6></div>
        <div class="card-body">
            <div class="row g-3">
                @foreach(['accepts_cash'=>'كاش','accepts_mada'=>'مدى','accepts_visa'=>'Visa/Master','accepts_apple_pay'=>'Apple Pay','accepts_google_pay'=>'Google Pay','accepts_bank_transfer'=>'تحويل بنكي'] as $f=>$l)
                    <div class="col-md-4">
                        <div class="form-check border rounded p-3">
                            <input class="form-check-input" type="checkbox" name="{{ $f }}" value="1" {{ ($setting->{$f} ?? false) ? 'checked' : '' }} id="pay-{{ $f }}">
                            <label class="form-check-label fw-bold" for="pay-{{ $f }}">{{ $l }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success btn-lg"><i class="las la-save"></i> حفظ التغييرات</button>
</form>
@endsection
