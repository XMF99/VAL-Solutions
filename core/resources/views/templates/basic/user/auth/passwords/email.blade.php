@extends($activeTemplate.'layouts.app')

@push('style')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Cairo', sans-serif !important; background: #F9FAFB; }

:root {
    --vp-500: #6366F1; --vp-600: #4F46E5; --vp-700: #4338CA; --vp-800: #3730A3;
    --vp-50: #EEF2FF; --vp-100: #E0E7FF;
    --g-25: #FCFCFD; --g-50: #F9FAFB; --g-100: #F2F4F7; --g-200: #EAECF0;
    --g-300: #D0D5DD; --g-400: #98A2B3; --g-500: #667085; --g-600: #475467;
    --g-700: #344054; --g-800: #1D2939; --g-900: #101828;
}

.vp-auth-page { min-height: 100vh; display: flex; direction: rtl; }
.vp-auth-left {
    flex: 1;
    background: linear-gradient(135deg, #4F46E5 0%, #4338CA 50%, #312E81 100%);
    color: white; padding: 60px 48px;
    display: flex; flex-direction: column; justify-content: space-between;
    position: relative; overflow: hidden;
}
.vp-auth-left::before {
    content: ''; position: absolute; top: -200px; left: -200px;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(255,255,255,0.15), transparent 60%);
}
.vp-auth-left::after {
    content: ''; position: absolute; bottom: -250px; right: -150px;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(199,210,254,0.2), transparent 60%);
}
.vp-auth-brand { position: relative; z-index: 1; display: flex; align-items: center; gap: 12px; }
.vp-auth-brand img { height: 36px; filter: brightness(0) invert(1); }
.vp-auth-hero { position: relative; z-index: 1; }
.vp-auth-hero h2 {
    font-size: 36px; font-weight: 900; margin-bottom: 14px;
    letter-spacing: -0.8px; line-height: 1.2;
}
.vp-auth-hero p {
    font-size: 16px; line-height: 1.7; color: rgba(255,255,255,0.85); max-width: 460px;
}
.vp-auth-features { position: relative; z-index: 1; display: flex; flex-direction: column; gap: 14px; }
.vp-auth-feat { display: flex; align-items: center; gap: 12px; font-size: 14px; font-weight: 600; }
.vp-auth-feat-icon {
    width: 36px; height: 36px;
    background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.25);
    border-radius: 10px; display: flex; align-items: center; justify-content: center;
    font-size: 16px; backdrop-filter: blur(10px);
}

.vp-auth-right { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 24px; background: white; }
.vp-auth-card { max-width: 460px; width: 100%; }
.vp-auth-icon {
    width: 72px; height: 72px; border-radius: 20px;
    background: linear-gradient(135deg, var(--vp-500), var(--vp-700));
    color: white; display: flex; align-items: center; justify-content: center;
    font-size: 32px; margin: 0 auto 24px;
    box-shadow: 0 16px 32px -8px rgba(79, 70, 229, 0.4);
}
.vp-auth-title {
    font-size: 28px; font-weight: 900; color: var(--g-900);
    text-align: center; margin-bottom: 8px; letter-spacing: -0.6px;
}
.vp-auth-subtitle {
    font-size: 15px; color: var(--g-500); text-align: center;
    margin-bottom: 32px; line-height: 1.6;
}
.vp-auth-form .form-group { margin-bottom: 18px; }
.vp-auth-form label {
    display: block; font-size: 13px; font-weight: 700; color: var(--g-700); margin-bottom: 6px;
}
.vp-auth-form input[type="email"],
.vp-auth-form input[type="text"] {
    width: 100%; padding: 13px 16px; border: 1.5px solid var(--g-200);
    border-radius: 10px; font-family: 'Cairo', sans-serif; font-size: 14px;
    color: var(--g-900); background: white; transition: all 0.15s; direction: rtl;
}
.vp-auth-form input:focus {
    outline: none; border-color: var(--vp-600);
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}
.vp-auth-btn {
    width: 100%; padding: 14px;
    background: linear-gradient(135deg, var(--vp-500), var(--vp-700));
    color: white; font-family: 'Cairo', sans-serif;
    font-size: 15px; font-weight: 800; border: none; border-radius: 10px;
    cursor: pointer; transition: all 0.2s;
    box-shadow: 0 8px 20px -4px rgba(79, 70, 229, 0.35);
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.vp-auth-btn:hover {
    box-shadow: 0 12px 28px -4px rgba(79, 70, 229, 0.5);
    transform: translateY(-2px);
}
.vp-auth-back {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    margin-top: 20px; color: var(--g-500); font-size: 14px; font-weight: 600;
    text-decoration: none; transition: color 0.15s;
}
.vp-auth-back:hover { color: var(--vp-600); }
.vp-auth-back svg { width: 16px; height: 16px; }

.vp-error {
    background: #FEF3F2; color: #B42318; padding: 12px 14px;
    border-radius: 10px; font-size: 13px; margin-bottom: 16px;
    border: 1px solid #FECDCA;
}

@media (max-width: 991px) {
    .vp-auth-page { flex-direction: column; }
    .vp-auth-left { padding: 28px 24px; }
    .vp-auth-hero h2 { font-size: 26px; }
    .vp-auth-features { display: none; }
}
</style>
@endpush

@section('content')
<div class="vp-auth-page">

    <!-- Left side - Brand -->
    <div class="vp-auth-left">
        <div class="vp-auth-brand">
            <img src="{{ asset('images/val-logo.png') }}" alt="Val POS" onerror="this.style.display='none'">
            <span style="font-size: 22px; font-weight: 900;">Val POS</span>
        </div>

        <div class="vp-auth-hero">
            <h2>لا تقلق، نحن هنا للمساعدة</h2>
            <p>سنرسل لك رابطاً آمناً لإعادة تعيين كلمة المرور خلال ثوانٍ. متجرك في انتظار عودتك.</p>
        </div>

        <div class="vp-auth-features">
            <div class="vp-auth-feat">
                <span class="vp-auth-feat-icon">🔐</span>
                <span>عمليّة آمنة ومشفّرة بالكامل</span>
            </div>
            <div class="vp-auth-feat">
                <span class="vp-auth-feat-icon">⚡</span>
                <span>إعادة تعيين سريعة في أقل من دقيقة</span>
            </div>
            <div class="vp-auth-feat">
                <span class="vp-auth-feat-icon">📧</span>
                <span>كود تحقّق يصل لبريدك مباشرة</span>
            </div>
        </div>
    </div>

    <!-- Right side - Form -->
    <div class="vp-auth-right">
        <div class="vp-auth-card">

            <div class="vp-auth-icon">📧</div>

            <h1 class="vp-auth-title">نسيت كلمة المرور؟</h1>
            <p class="vp-auth-subtitle">أدخل بريدك الإلكتروني أو اسم المستخدم،<br>وسنرسل لك كوداً لإعادة التعيين</p>

            @if(session('error'))
                <div class="vp-error">⚠ {{ session('error') }}</div>
            @endif

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="vp-error">⚠ {{ $error }}</div>
                @endforeach
            @endif

            <form action="{{ route('user.password.email') }}" method="POST" class="vp-auth-form verify-gcaptcha">
                @csrf

                <div class="form-group">
                    <label for="value">البريد الإلكتروني أو اسم المستخدم</label>
                    <input type="text" name="value" id="value"
                           placeholder="ادخل بريدك الإلكتروني أو اسم المستخدم"
                           value="{{ old('value') }}" required>
                </div>

                <x-captcha />

                <button type="submit" class="vp-auth-btn">
                    إرسال كود التحقّق
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </button>
            </form>

            <a href="{{ route('user.login') }}" class="vp-auth-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
                العودة لتسجيل الدخول
            </a>

        </div>
    </div>

</div>
@endsection
