@extends($activeTemplate . 'layouts.master')

@push('style')
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<style>
/* Tajawal للنصوص فقط — الأيقونات ترجع لـ Line Awesome */
.wa-upgrade-page,
.wa-upgrade-page h1, .wa-upgrade-page h2, .wa-upgrade-page h3,
.wa-upgrade-page h4, .wa-upgrade-page h5, .wa-upgrade-page h6,
.wa-upgrade-page p, .wa-upgrade-page span, .wa-upgrade-page div,
.wa-upgrade-page strong, .wa-upgrade-page a, .wa-upgrade-page button {
    font-family: 'Tajawal', 'Segoe UI', sans-serif !important;
}

/* الأيقونات ترجع للـ font الأصلي */
.wa-upgrade-page i.las,
.wa-upgrade-page i.lab,
.wa-upgrade-page i.lar,
.wa-upgrade-page i.laf,
.wa-upgrade-page i[class*="la-"] {
    font-family: 'Line Awesome Free', 'Line Awesome Brands' !important;
    font-style: normal !important;
}

/* Hero */
.wa-upgrade-hero {
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: #FFFFFF !important;
    border-radius: 1.25rem;
    padding: 3.5rem 2rem;
    text-align: center;
    box-shadow: 0 20px 60px rgba(37, 211, 102, .25);
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}
.wa-upgrade-hero::before {
    content: '';
    position: absolute;
    top: -50%; left: -50%;
    width: 200%; height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,.08) 0%, transparent 50%);
    animation: pulse 4s ease-in-out infinite;
}
@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: .5; }
    50% { transform: scale(1.05); opacity: .8; }
}

.wa-upgrade-hero > * { position: relative; z-index: 1; }

.wa-upgrade-hero,
.wa-upgrade-hero h2,
.wa-upgrade-hero p,
.wa-upgrade-hero strong,
.wa-upgrade-hero .lead {
    color: #FFFFFF !important;
}

.wa-upgrade-hero .wa-icon {
    font-size: 5.5rem;
    margin-bottom: 1.25rem;
    color: #FFFFFF !important;
    filter: drop-shadow(0 4px 12px rgba(0,0,0,.2));
}

.wa-upgrade-hero h2 {
    font-size: 2.25rem;
    font-weight: 900;
    margin-bottom: 1rem;
    color: #FFFFFF !important;
}

.wa-upgrade-hero .lead {
    font-size: 1.15rem;
    font-weight: 400;
    max-width: 650px;
    margin: 0 auto 2.5rem;
    line-height: 1.8;
}

/* Plan Badge */
.wa-plan-badge {
    background: rgba(255,255,255,.22);
    padding: .5rem 1.25rem;
    border-radius: 1.5rem;
    font-size: .9rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    margin-bottom: 1.75rem;
    border: 1px solid rgba(255,255,255,.3);
    color: #FFFFFF !important;
}
.wa-plan-badge i { color: #FFD700 !important; }

/* Feature Grid */
.wa-feature-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
    max-width: 800px;
    margin: 0 auto 2.5rem;
}
@media (min-width: 768px) {
    .wa-feature-grid { grid-template-columns: repeat(4, 1fr); }
}

.wa-feature-item {
    background: rgba(255,255,255,.15);
    border-radius: 1rem;
    padding: 1.75rem 1rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.25);
    transition: all .35s cubic-bezier(.34, 1.56, .64, 1);
    cursor: default;
    position: relative;
    overflow: hidden;
}
.wa-feature-item:hover {
    transform: translateY(-6px) scale(1.02);
    background: rgba(255,255,255,.25);
    border-color: rgba(255,255,255,.5);
    box-shadow: 0 15px 35px rgba(0,0,0,.2);
}

.wa-feature-icon-wrap {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(255,255,255,.25);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto .85rem;
    transition: all .3s;
}
.wa-feature-item:hover .wa-feature-icon-wrap {
    background: rgba(255,255,255,.4);
    transform: scale(1.1) rotate(5deg);
}
.wa-feature-icon-wrap i {
    font-size: 1.85rem;
    color: #FFFFFF !important;
}

.wa-feature-item h6 {
    font-weight: 700;
    margin-bottom: .35rem;
    font-size: 1rem;
    color: #FFFFFF !important;
}
.wa-feature-item p {
    font-size: .85rem;
    margin: 0;
    line-height: 1.5;
    font-weight: 400;
    color: #FFFFFF !important;
    opacity: .95;
}

/* الزر الأخضر الجذّاب */
.btn-wa-upgrade {
    background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
    color: #FFFFFF !important;
    font-weight: 900 !important;
    padding: 1.15rem 3.5rem;
    border-radius: 1rem;
    border: 2px solid rgba(255,255,255,.4);
    transition: all .3s;
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    gap: .25rem;
    text-decoration: none !important;
    box-shadow: 0 8px 25px rgba(22, 163, 74, .5),
                inset 0 1px 0 rgba(255,255,255,.2);
    line-height: 1.3;
    position: relative;
    overflow: hidden;
}
.btn-wa-upgrade::before {
    content: '';
    position: absolute;
    top: 0; right: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.3), transparent);
    transition: right .6s;
}
.btn-wa-upgrade:hover::before { right: 100%; }
.btn-wa-upgrade:hover {
    background: linear-gradient(135deg, #15803d 0%, #166534 100%);
    transform: translateY(-3px);
    color: #FFFFFF !important;
    border-color: #FFFFFF;
    box-shadow: 0 12px 35px rgba(22, 163, 74, .65),
                inset 0 1px 0 rgba(255,255,255,.3);
}

.btn-wa-upgrade .main-text {
    font-size: 1.2rem;
    font-weight: 900;
    color: #FFFFFF !important;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.btn-wa-upgrade .main-text i { color: #FFFFFF !important; }
.btn-wa-upgrade .sub-text {
    font-size: .85rem;
    font-weight: 500;
    color: #FFFFFF !important;
    opacity: .9;
}

.wa-current-plan {
    margin-top: 1.5rem;
    font-size: .95rem;
    color: #FFFFFF !important;
    font-weight: 500;
}
.wa-current-plan i { color: #FFFFFF !important; }
.wa-current-plan strong { color: #FFFFFF !important; font-weight: 700; }

/* البطاقات السفليّة */
.wa-info-card {
    font-family: 'Tajawal', sans-serif !important;
}
.wa-info-card * {
    font-family: 'Tajawal', sans-serif !important;
}
.wa-info-card i.las, .wa-info-card i.lab, .wa-info-card i[class*="la-"] {
    font-family: 'Line Awesome Free', 'Line Awesome Brands' !important;
}
</style>
@endpush

@section('panel')
<div class="wa-upgrade-page">

<div class="wa-upgrade-hero">
    <div class="wa-icon">
        <i class="lab la-whatsapp"></i>
    </div>

    <span class="wa-plan-badge">
        <i class="las la-crown"></i>
        ميزة حصريّة - الباقة الشاملة
    </span>

    <h2>متجر الواتس اب</h2>
    <p class="lead">
        يجب عليك الاشتراك في <strong>الباقة الشاملة</strong> للحصول على متجر الواتس اب.<br>
        استلم الطلبات مباشرة من عملائك، وحوّلها للكاشير بضغطة.
    </p>

    <div class="wa-feature-grid">
        <div class="wa-feature-item">
            <div class="wa-feature-icon-wrap">
                <i class="las la-shopping-bag"></i>
            </div>
            <h6>طلبات لحظيّة</h6>
            <p>من الواتس اب لكاشيرك مباشرة</p>
        </div>
        <div class="wa-feature-item">
            <div class="wa-feature-icon-wrap">
                <i class="las la-boxes"></i>
            </div>
            <h6>كاتالوج Meta</h6>
            <p>منتجاتك في تطبيق العملاء</p>
        </div>
        <div class="wa-feature-item">
            <div class="wa-feature-icon-wrap">
                <i class="las la-credit-card"></i>
            </div>
            <h6>دفع إلكتروني</h6>
            <p>مدى، Visa، Apple Pay</p>
        </div>
        <div class="wa-feature-item">
            <div class="wa-feature-icon-wrap">
                <i class="las la-store"></i>
            </div>
            <h6>متجر مستقلّ</h6>
            <p>رابط خاصّ لكلّ تاجر</p>
        </div>
    </div>

    <a href="{{ url('/user/subscription/plan/index') }}" class="btn-wa-upgrade">
        <span class="main-text">
            <i class="las la-arrow-up"></i> اشترك الآن
        </span>
        <span class="sub-text">ترقية</span>
    </a>

    <div class="wa-current-plan">
        @if($currentPlanId == 0)
            <i class="las la-info-circle"></i> ليس لديك اشتراك نشط حالياً
        @elseif($currentPlanId == 1)
            <i class="las la-info-circle"></i> باقتك الحالية: <strong>الأساسيّة</strong>
        @elseif($currentPlanId == 2)
            <i class="las la-info-circle"></i> باقتك الحالية: <strong>الاحترافيّة</strong>
        @endif
    </div>
</div>

<div class="row g-3 wa-info-card">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px;">
                    <i class="las la-bolt text-success" style="font-size:1.75rem"></i>
                </div>
                <h5 class="fw-bold">ردود تلقائيّة</h5>
                <p class="text-muted small mb-0">رسائل ترحيب + قائمة منتجات تُرسل تلقائياً للعملاء</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px;">
                    <i class="las la-chart-line text-primary" style="font-size:1.75rem"></i>
                </div>
                <h5 class="fw-bold">تقارير لحظيّة</h5>
                <p class="text-muted small mb-0">تابع طلبات الواتس اب والإيرادات في الوقت الفعلي</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px;">
                    <i class="las la-link text-warning" style="font-size:1.75rem"></i>
                </div>
                <h5 class="fw-bold">دمج كامل</h5>
                <p class="text-muted small mb-0">كلّ طلب يتحوّل لـ POS مع تحديث المخزون تلقائياً</p>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
