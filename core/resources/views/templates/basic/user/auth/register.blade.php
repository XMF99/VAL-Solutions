@extends('Template::layouts.app')

@push('style')
<style>
:root {
    --vp-primary: #4F46E5;
    --vp-primary-dark: #4338CA;
    --vp-primary-light: #EEF2FF;
    --vp-primary-soft: #E0E7FF;
    --vp-text: #0F0F1A;
    --vp-text-2: #4B5563;
    --vp-text-3: #9CA3AF;
    --vp-bg: #F9FAFB;
    --vp-bg-card: #FFFFFF;
    --vp-border: #E5E7EB;
}
.vp-reg * { box-sizing: border-box; }
.vp-reg {
    font-family: 'Cairo', 'Tajawal', system-ui, sans-serif !important;
    direction: rtl;
    background: linear-gradient(135deg, #F5F7FE 0%, #EEF2FF 100%);
    min-height: 100vh;
    padding: 30px 20px 60px;
}
.vp-wrap { max-width: 1100px; margin: 0 auto; }

.vp-header { text-align: center; margin-bottom: 32px; }
.vp-logo { display: inline-block; margin-bottom: 24px; }
.vp-logo img { height: 42px; }
.vp-eyebrow {
    display: inline-block;
    background: var(--vp-primary-light);
    color: var(--vp-primary);
    padding: 7px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 800;
    margin-bottom: 16px;
}
.vp-title {
    font-family: 'Cairo', sans-serif;
    font-size: clamp(26px, 4vw, 38px);
    font-weight: 900;
    line-height: 1.2;
    letter-spacing: -1px;
    color: var(--vp-text);
    margin-bottom: 10px;
}
.vp-subtitle {
    color: var(--vp-text-2);
    font-size: 15px;
    max-width: 600px;
    margin: 0 auto;
}

.vp-plans-label {
    text-align: center;
    font-size: 14px;
    font-weight: 700;
    color: var(--vp-text-2);
    margin: 32px 0 18px;
}
.vp-plans-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 36px;
}

.vp-plan {
    background: white;
    border: 2px solid var(--vp-border);
    border-radius: 18px;
    padding: 22px 18px 18px;
    cursor: pointer;
    transition: all 0.25s ease;
    position: relative;
    text-align: center;
}
.vp-plan::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: var(--c);
    border-radius: 16px 16px 0 0;
    opacity: 0.5;
}
.vp-plan:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.08); border-color: var(--c); }
.vp-plan.active {
    border-color: var(--c);
    background: var(--bg);
    box-shadow: 0 16px 40px var(--sh);
    transform: translateY(-2px);
}
.vp-plan.active::before { opacity: 1; height: 5px; }

.vp-plan[data-plan="basic"]        { --c: #10B981; --bg: #ECFDF5; --sh: rgba(16,185,129,0.25); }
.vp-plan[data-plan="advanced"]     { --c: #3B82F6; --bg: #EFF6FF; --sh: rgba(59,130,246,0.25); }
.vp-plan[data-plan="professional"] { --c: #4F46E5; --bg: #EEF2FF; --sh: rgba(79,70,229,0.3); }
.vp-plan[data-plan="enterprise"]   { --c: #F59E0B; --bg: #FEF3C7; --sh: rgba(245,158,11,0.3); }

.vp-popular {
    position: absolute;
    top: 10px;
    right: 50%;
    transform: translateX(50%);
    background: linear-gradient(135deg, #4F46E5, #4338CA);
    color: white;
    padding: 3px 12px;
    border-radius: 100px;
    font-size: 9px;
    font-weight: 800;
    white-space: nowrap;
}
.vp-plan[data-plan="enterprise"] .vp-popular {
    background: linear-gradient(135deg, #F59E0B, #D97706);
}

.vp-plan-icon {
    width: 44px; height: 44px; margin: 14px auto 12px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    background: var(--bg);
    color: var(--c);
}
.vp-plan.active .vp-plan-icon { background: white; }
.vp-plan-name {
    font-family: 'Cairo', sans-serif;
    font-size: 16px;
    font-weight: 900;
    margin-bottom: 4px;
}
.vp-plan-tag {
    font-size: 11px;
    color: var(--vp-text-3);
    margin-bottom: 14px;
    min-height: 16px;
}
.vp-plan-price {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 3px;
}
.vp-plan-price .num {
    font-family: 'Cairo', sans-serif;
    font-size: 28px;
    font-weight: 900;
    line-height: 1;
}
.vp-plan.active .vp-plan-price .num { color: var(--c); }
.vp-plan-price .unit { font-size: 11px; color: var(--vp-text-3); font-weight: 600; }

.vp-plan-check {
    position: absolute;
    top: 14px;
    left: 14px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid var(--vp-border);
    background: white;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
}
.vp-plan.active .vp-plan-check {
    border-color: var(--c);
    background: var(--c);
    color: white;
}
.vp-plan-check svg { width: 12px; opacity: 0; transition: opacity 0.2s; }
.vp-plan.active .vp-plan-check svg { opacity: 1; }

.vp-form-card {
    background: white;
    border-radius: 24px;
    padding: 36px;
    max-width: 720px;
    margin: 0 auto;
    box-shadow: 0 24px 60px rgba(79, 70, 229, 0.08);
    border: 1px solid rgba(79, 70, 229, 0.06);
}
.vp-form-title {
    font-family: 'Cairo', sans-serif;
    font-size: 24px;
    font-weight: 900;
    color: var(--vp-text);
    margin-bottom: 6px;
    text-align: center;
}
.vp-form-sub {
    color: var(--vp-text-3);
    font-size: 14px;
    margin-bottom: 22px;
    text-align: center;
}
.vp-trial {
    background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
    color: #047857;
    padding: 12px 16px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 13px;
    margin-bottom: 24px;
    text-align: center;
}

.vp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.vp-group { margin-bottom: 14px; }
.vp-label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: var(--vp-text);
    margin-bottom: 6px;
}
.vp-input {
    width: 100%;
    padding: 13px 15px;
    background: #F9FAFB;
    border: 1.5px solid var(--vp-border);
    border-radius: 12px;
    font-family: inherit;
    font-size: 14px;
    color: var(--vp-text);
    transition: all 0.2s;
    direction: rtl;
}
.vp-input:focus {
    outline: none;
    border-color: var(--vp-primary);
    background: white;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.vp-mobile-row { display: flex; gap: 8px; }
.vp-mobile-row select { flex: 0 0 110px; padding: 13px 8px; font-size: 13px; }
.vp-mobile-row input { flex: 1; }

.vp-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin: 20px 0;
    font-size: 13px;
    color: var(--vp-text-2);
    line-height: 1.6;
}
.vp-checkbox input { margin-top: 3px; accent-color: var(--vp-primary); }
.vp-checkbox a { color: var(--vp-primary); font-weight: 700; }

.vp-submit {
    width: 100%;
    padding: 16px;
    background: var(--vp-primary);
    color: white;
    border: none;
    border-radius: 14px;
    font-family: inherit;
    font-size: 15px;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.2s;
    margin-top: 8px;
    box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
}
.vp-submit:hover {
    background: var(--vp-primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(79, 70, 229, 0.4);
}

.vp-login-link {
    text-align: center;
    margin-top: 24px;
    font-size: 13px;
    color: var(--vp-text-2);
}
.vp-login-link a { color: var(--vp-primary); font-weight: 700; text-decoration: none; }

.vp-errors {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 18px;
    font-size: 13px;
    color: #B91C1C;
    list-style: none;
}

@media (max-width: 768px) {
    .vp-reg { padding: 20px 14px 40px; }
    .vp-plans-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
    .vp-plan { padding: 18px 12px 14px; }
    .vp-plan-icon { width: 38px; height: 38px; font-size: 18px; margin: 12px auto 8px; }
    .vp-plan-name { font-size: 14px; }
    .vp-plan-price .num { font-size: 24px; }
    .vp-form-card { padding: 24px 20px; border-radius: 18px; }
    .vp-row { grid-template-columns: 1fr; gap: 0; }
}
@media (max-width: 380px) {
    .vp-plans-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('app-content')
<div class="vp-reg">
    <div class="vp-wrap">

        <div class="vp-header">
            <a href="/" class="vp-logo">
                <img src="/images/val-logo-dark.png" alt="Val Solutions">
            </a>
            <div class="vp-eyebrow">ابدأ تجربتك المجانيّة</div>
            <h1 class="vp-title">١٤ يوم تجربة كاملة بدون بطاقة ائتمان</h1>
            <p class="vp-subtitle">جرّب Val POS بكل مميزاته المتقدّمة. لا التزامات. ألغِ متى تشاء.</p>
        </div>

        <p class="vp-plans-label">١. اختر الباقة المناسبة لك</p>
        <div class="vp-plans-grid">
            @php
                $planMeta = [
                    'basic' => ['icon' => '🏪', 'tag' => 'للمتاجر الصغيرة', 'name' => 'الأساسيّة'],
                    'advanced' => ['icon' => '📈', 'tag' => 'للمتاجر النامية', 'name' => 'المتقدّمة'],
                    'professional' => ['icon' => '⭐', 'tag' => 'لسلاسل الفروع', 'name' => 'الاحترافيّة', 'popular' => true],
                    'enterprise' => ['icon' => '🤖', 'tag' => 'AI كامل + غير محدود', 'name' => 'الشاملة', 'ai' => true],
                ];
                $slugMap = [1 => 'basic', 2 => 'advanced', 3 => 'professional', 4 => 'enterprise'];
            @endphp

            @if(isset($plans))
                @foreach($plans as $plan)
                    @php $s = $slugMap[$plan->id] ?? 'basic'; $m = $planMeta[$s]; @endphp
                    <div class="vp-plan {{ ($planSlug ?? 'basic') === $s ? 'active' : '' }}" 
                         data-plan="{{ $s }}"
                         onclick="selectPlan('{{ $s }}', this)">
                        @if(isset($m['popular']))<div class="vp-popular">⭐ الأكثر طلباً</div>@endif
                        @if(isset($m['ai']))<div class="vp-popular">🤖 AI</div>@endif
                        <div class="vp-plan-check">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="vp-plan-icon">{{ $m['icon'] }}</div>
                        <div class="vp-plan-name">{{ $m['name'] }}</div>
                        <div class="vp-plan-tag">{{ $m['tag'] }}</div>
                        <div class="vp-plan-price">
                            <span class="num">{{ $plan->monthly_price }}</span>
                            <span class="unit">ر.س/شهر</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="vp-form-card">
            <h2 class="vp-form-title">٢. إنشاء حسابك</h2>
            <p class="vp-form-sub">املأ بياناتك وابدأ تجربتك المجانيّة</p>

            <div class="vp-trial">🎁 ١٤ يوم تجربة مجانيّة — بدون بطاقة ائتمان</div>

            @if($errors->any())
            <ul class="vp-errors">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
            @endif

            <form method="POST" action="{{ route('user.register') }}">
                @csrf
                <input type="hidden" name="plan_slug" id="planSlugInput" value="{{ $planSlug ?? 'basic' }}">

                <div class="vp-row">
                    <div class="vp-group">
                        <label class="vp-label">الاسم الأوّل *</label>
                        <input type="text" name="firstname" class="vp-input" placeholder="أحمد" value="{{ old('firstname') }}" required>
                    </div>
                    <div class="vp-group">
                        <label class="vp-label">اسم العائلة *</label>
                        <input type="text" name="lastname" class="vp-input" placeholder="الحربي" value="{{ old('lastname') }}" required>
                    </div>
                </div>

                <div class="vp-group">
                    <label class="vp-label">اسم النشاط التجاري *</label>
                    <input type="text" name="business_name" class="vp-input" placeholder="مطعم فودي" value="{{ old('business_name') }}" required>
                </div>

                <div class="vp-group">
                    <label class="vp-label">البريد الإلكتروني *</label>
                    <input type="email" name="email" class="vp-input" placeholder="ahmed@example.com" value="{{ old('email') }}" required>
                </div>

                <div class="vp-group">
                    <label class="vp-label">رقم الجوّال *</label>
                    <div class="vp-mobile-row">
                        <select name="mobile_code" class="vp-input">
                            @if(isset($countries))
                                @foreach($countries as $key => $country)
                                    <option value="{{ $country->dial_code }}" {{ $key == 'SA' ? 'selected' : '' }}>
                                        +{{ $country->dial_code }} ({{ $key }})
                                    </option>
                                @endforeach
                            @else
                                <option value="966" selected>+966 (SA)</option>
                            @endif
                        </select>
                        <input type="text" name="mobile" class="vp-input" placeholder="5xxxxxxxx" value="{{ old('mobile') }}" required>
                    </div>
                </div>

                <div class="vp-row">
                    <div class="vp-group">
                        <label class="vp-label">كلمة المرور *</label>
                        <input type="password" name="password" class="vp-input" placeholder="٦ أحرف على الأقل" required>
                    </div>
                    <div class="vp-group">
                        <label class="vp-label">تأكيد كلمة المرور *</label>
                        <input type="password" name="password_confirmation" class="vp-input" placeholder="أعد كتابتها" required>
                    </div>
                </div>

                @if(gs('agree'))
                <div class="vp-checkbox">
                    <input type="checkbox" name="agree" id="agree" required>
                    <label for="agree">
                        أوافق على <a href="/policy/terms" target="_blank">الشروط والأحكام</a>
                        و <a href="/policy/privacy" target="_blank">سياسة الخصوصيّة</a>
                    </label>
                </div>
                @endif

                <button type="submit" class="vp-submit">🚀 ابدأ تجربتي المجانيّة</button>

                <p class="vp-login-link">
                    لديك حساب بالفعل؟ <a href="{{ route('user.login') }}">سجّل الدخول</a>
                </p>
            </form>
        </div>
    </div>
</div>

<script>
function selectPlan(slug, el) {
    document.querySelectorAll('.vp-plan').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('planSlugInput').value = slug;
    const url = new URL(window.location);
    url.searchParams.set('plan', slug);
    window.history.replaceState({}, '', url);
}
</script>
@endsection
