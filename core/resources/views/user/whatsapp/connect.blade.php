@extends($activeTemplate . 'layouts.master')
@push('style')<style>.wa-tabs{display:flex;gap:0;border-bottom:2px solid #e5e7eb;overflow-x:auto}.wa-tabs a{padding:.75rem 1.25rem;font-weight:600;font-size:.875rem;color:#64748b;border-bottom:2px solid transparent;margin-bottom:-2px;text-decoration:none;display:flex;align-items:center;gap:.4rem}.wa-tabs a.active{color:#059669;border-color:#10b981}</style>@endpush
@section('panel')
@include('user.whatsapp.partials._tabs')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header bg-white"><h6 class="mb-0">خطوات الربط (مرّة واحدة)</h6></div>
            <div class="card-body">
                @foreach(['افتح Meta Business: business.facebook.com','فعّل WhatsApp Business Platform','انسخ Access Token + Phone Number ID','الصقهم أدناه واربط'] as $i=>$s)
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:28px;height:28px;flex-shrink:0">{{ $i+1 }}</div>
                    <span>{{ $s }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <form method="POST" action="{{ route('user.whatsapp.connect.manual') }}" class="card">
            @csrf
            <div class="card-header bg-white"><h6 class="mb-0">بيانات الربط</h6></div>
            <div class="card-body">
                <div class="mb-3"><label class="form-label fw-bold">رقم الواتس اب الأعمال</label><input name="whatsapp_number" required placeholder="966XXXXXXXXX" class="form-control"></div>
                <div class="mb-3"><label class="form-label fw-bold">Phone Number ID</label><input name="whatsapp_phone_id" required class="form-control"></div>
                <div class="mb-3"><label class="form-label fw-bold">Access Token</label><input type="password" name="access_token" required class="form-control"></div>
                <button type="submit" class="btn btn-success btn-lg w-100"><i class="lab la-whatsapp"></i> ربط الحساب</button>
            </div>
        </form>
    </div>
</div>
@endsection
