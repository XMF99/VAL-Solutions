@extends($activeTemplate . 'layouts.master')

@push('style')
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<style>
.upg-page,.upg-page *{font-family:'Tajawal',sans-serif!important;}
.upg-page i.las,.upg-page i.lab,.upg-page i[class*="la-"]{font-family:'Line Awesome Free','Line Awesome Brands'!important;font-style:normal!important;}
.upg-hero{background:linear-gradient(135deg,#25D366 0%,#128C7E 100%);color:#fff!important;border-radius:1.25rem;padding:2.5rem 2rem;text-align:center;box-shadow:0 15px 40px rgba(37,211,102,.25);margin-bottom:1.5rem;}
.upg-hero h2,.upg-hero p,.upg-hero i,.upg-hero .badge-info{color:#fff!important;}
.upg-hero h2{font-size:2rem;font-weight:900;margin:0 0 .5rem 0;}
.upg-hero .icon{font-size:3.5rem;margin-bottom:.75rem;color:#fff!important;}
.upg-fee-badge{background:rgba(255,255,255,.25);padding:.4rem 1rem;border-radius:1rem;font-size:.9rem;font-weight:600;display:inline-block;margin-top:.5rem;}
.upg-card{background:#fff;border-radius:1rem;padding:2rem;box-shadow:0 4px 20px rgba(0,0,0,.05);margin-bottom:1.5rem;}
.upg-comp{display:grid;grid-template-columns:1fr auto 1fr;gap:1rem;align-items:center;margin-bottom:1.5rem;}
.upg-mini{background:#f9fafb;border-radius:.75rem;padding:1.25rem;text-align:center;border:2px solid transparent;}
.upg-mini.target{background:linear-gradient(135deg,#ecfdf5 0%,#d1fae5 100%);border-color:#25D366;}
.upg-mini .name{font-weight:800;font-size:1.1rem;margin-bottom:.25rem;color:#111827;}
.upg-mini .price{font-size:1.25rem;font-weight:900;color:#128C7E;}
.upg-mini .period{font-size:.8rem;color:#6b7280;}
.upg-arrow{font-size:2rem;color:#25D366;}
.upg-row{display:flex;justify-content:space-between;align-items:center;padding:.85rem 0;border-bottom:1px dashed #e5e7eb;font-size:1.05rem;}
.upg-row:last-of-type{border-bottom:none;}
.upg-row .label{color:#6b7280;font-weight:600;}
.upg-row .value{color:#111827;font-weight:700;}
.upg-row.diff .value{color:#059669;}
.upg-row.fee .value{color:#d97706;}
.upg-row.total{margin-top:1rem;padding-top:1.25rem;border-top:2px solid #25D366;font-size:1.35rem;}
.upg-row.total .label{color:#128C7E;font-weight:800;}
.upg-row.total .value{color:#128C7E;font-weight:900;}
.btn-upg-pay{background:linear-gradient(135deg,#16a34a 0%,#15803d 100%);color:#fff!important;font-weight:900;padding:1.1rem 2rem;border-radius:.85rem;border:none;width:100%;font-size:1.1rem;box-shadow:0 8px 25px rgba(22,163,74,.35);transition:all .25s;display:inline-flex;align-items:center;justify-content:center;gap:.5rem;}
.btn-upg-pay:hover{transform:translateY(-2px);box-shadow:0 12px 30px rgba(22,163,74,.5);color:#fff!important;}
.gw-list{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:.75rem;margin-top:.75rem;}
.gw-card{border:2px solid #e5e7eb;border-radius:.75rem;padding:1rem;cursor:pointer;transition:all .2s;text-align:center;background:#fff;}
.gw-card:hover{border-color:#25D366;}
.gw-card.selected{border-color:#25D366;background:#f0fdf4;}
.gw-card input{display:none;}
.gw-card .gw-name{font-weight:700;font-size:.9rem;color:#111827;}
</style>
@endpush

@section('panel')
<div class="upg-page">
<div class="upg-hero">
    <div class="icon"><i class="las la-rocket"></i></div>
    <h2>ترقية الباقة</h2>
    <p>ادفع فقط فرق السعر بين باقتك الحالية والباقة الجديدة</p>
    <div class="upg-fee-badge"><i class="las la-info-circle"></i> رسوم الترقية: {{ $upgradeData['upgrade_fee_percent'] }}%</div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="upg-card">
            <div class="upg-comp">
                <div class="upg-mini">
                    <div class="name">{{ $currentPlan->name }}</div>
                    <div class="price">{{ number_format($upgradeData['current_price'], 2) }} ر</div>
                    <div class="period">باقتك الحالية</div>
                </div>
                <div class="upg-arrow"><i class="las la-arrow-left"></i></div>
                <div class="upg-mini target">
                    <div class="name">{{ $targetPlan->name }}</div>
                    <div class="price">{{ number_format($upgradeData['target_price'], 2) }} ر</div>
                    <div class="period">الباقة الجديدة</div>
                </div>
            </div>
            <hr class="my-4">
            <div class="upg-row diff">
                <span class="label"><i class="las la-equals"></i> الفرق بين الباقتين</span>
                <span class="value">{{ number_format($upgradeData['difference'], 2) }} ر</span>
            </div>
            <div class="upg-row fee">
                <span class="label"><i class="las la-percentage"></i> رسوم الترقية ({{ $upgradeData['upgrade_fee_percent'] }}%)</span>
                <span class="value">{{ number_format($upgradeData['upgrade_fee'], 2) }} ر</span>
            </div>
            <div class="upg-row total">
                <span class="label"><i class="las la-coins"></i> الإجمالي للدفع</span>
                <span class="value">{{ number_format($upgradeData['total'], 2) }} ر</span>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="upg-card">
            <h5 class="mb-3 fw-bold"><i class="las la-credit-card text-success"></i> طريقة الدفع</h5>
            <form method="POST" action="{{ route('user.whatsapp.upgrade.process', $targetPlan->id) }}">
                @csrf
                <input type="hidden" name="recurring_type" value="{{ $recurringType }}">
                <div class="gw-list">
                    @foreach($gatewayCurrency as $gateway)
                        <label class="gw-card {{ $loop->first ? 'selected' : '' }}" onclick="upgSelectGW(this)">
                            <input type="radio" name="gateway" value="{{ $gateway->method_code }}" {{ $loop->first ? 'checked' : '' }} required>
                            <input type="hidden" name="currency" value="{{ $gateway->currency }}" class="upg-cur" {{ $loop->first ? '' : 'disabled' }}>
                            <div class="gw-name">{{ $gateway->name }}</div>
                            <div class="text-muted small mt-1">{{ $gateway->currency }}</div>
                        </label>
                    @endforeach
                </div>
                <button type="submit" class="btn-upg-pay mt-4">
                    <i class="las la-lock"></i>
                    ادفع وفعّل الباقة ({{ number_format($upgradeData['total'], 2) }} ر)
                </button>
                <p class="text-center text-muted small mt-3 mb-0"><i class="las la-shield-alt"></i> دفع آمن — تفعيل فوري بعد الدفع</p>
            </form>
        </div>
    </div>
</div>
</div>

<script>
function upgSelectGW(card){
    document.querySelectorAll('.gw-card').forEach(function(c){
        c.classList.remove('selected');
        var r=c.querySelector('input[type=radio]'); var u=c.querySelector('.upg-cur');
        r.checked=false; if(u) u.disabled=true;
    });
    card.classList.add('selected');
    var r=card.querySelector('input[type=radio]'); var u=card.querySelector('.upg-cur');
    r.checked=true; if(u) u.disabled=false;
}
</script>
@endsection
