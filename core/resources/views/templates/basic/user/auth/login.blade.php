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
    --vp-success: #10B981;
    --vp-error: #EF4444;
}

.vp-login-page * { box-sizing: border-box; }
.vp-login-page {
    font-family: 'Cairo', 'Tajawal', system-ui, sans-serif !important;
    direction: rtl;
    min-height: 100vh;
    background: linear-gradient(135deg, #F5F7FE 0%, #EEF2FF 100%);
    padding: 40px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vp-login-wrap {
    width: 100%;
    max-width: 460px;
}

.vp-login-card {
    background: var(--vp-bg-card);
    border-radius: 24px;
    padding: 44px 36px;
    box-shadow: 0 24px 60px rgba(79, 70, 229, 0.12), 0 4px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(79, 70, 229, 0.08);
}

.vp-logo-wrap {
    text-align: center;
    margin-bottom: 24px;
}
.vp-logo-wrap img {
    height: 40px;
    width: auto;
}

.vp-welcome-icon {
    width: 76px;
    height: 76px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, var(--vp-primary-light) 0%, var(--vp-primary-soft) 100%);
    border-radius: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    box-shadow: 0 8px 20px rgba(79, 70, 229, 0.15);
}

.vp-login-title {
    font-family: 'Cairo', sans-serif;
    font-size: 26px;
    font-weight: 900;
    color: var(--vp-text);
    text-align: center;
    margin-bottom: 6px;
    letter-spacing: -0.5px;
}

.vp-login-subtitle {
    color: var(--vp-text-3);
    font-size: 14px;
    text-align: center;
    margin-bottom: 30px;
    line-height: 1.6;
}

.vp-form-group {
    margin-bottom: 16px;
}

.vp-form-label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: var(--vp-text);
    margin-bottom: 8px;
}

.vp-input-wrap {
    position: relative;
}

.vp-input-icon {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--vp-text-3);
    font-size: 18px;
    pointer-events: none;
    z-index: 1;
}

.vp-form-input {
    width: 100%;
    padding: 14px 44px 14px 16px;
    background: var(--vp-bg);
    border: 1.5px solid var(--vp-border);
    border-radius: 14px;
    font-family: inherit;
    font-size: 14px;
    color: var(--vp-text);
    transition: all 0.2s;
    direction: rtl;
}
.vp-form-input:focus {
    outline: none;
    border-color: var(--vp-primary);
    background: white;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}
.vp-form-input::placeholder { color: #BDBDBD; }

.vp-form-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 20px 0 24px;
    font-size: 13px;
}

.vp-remember {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--vp-text-2);
    cursor: pointer;
    font-weight: 600;
}
.vp-remember input {
    width: 16px;
    height: 16px;
    accent-color: var(--vp-primary);
    cursor: pointer;
}

.vp-forgot-link {
    color: var(--vp-primary);
    text-decoration: none;
    font-weight: 700;
}
.vp-forgot-link:hover {
    text-decoration: underline;
    color: var(--vp-primary-dark);
}

.vp-btn-primary {
    width: 100%;
    padding: 15px;
    background: var(--vp-primary);
    color: white;
    border: none;
    border-radius: 14px;
    font-family: inherit;
    font-size: 15px;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.vp-btn-primary:hover {
    background: var(--vp-primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(79, 70, 229, 0.4);
}

.vp-divider {
    display: flex;
    align-items: center;
    margin: 24px 0;
    color: var(--vp-text-3);
    font-size: 12px;
}
.vp-divider::before,
.vp-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--vp-border);
}
.vp-divider span {
    padding: 0 14px;
    font-weight: 600;
}

.vp-signup-text {
    text-align: center;
    color: var(--vp-text-2);
    font-size: 13px;
    margin-bottom: 12px;
    font-weight: 600;
}

.vp-btn-secondary {
    width: 100%;
    padding: 14px;
    background: var(--vp-primary-light);
    color: var(--vp-primary);
    border: 1.5px solid var(--vp-primary-soft);
    border-radius: 14px;
    font-family: inherit;
    font-size: 14px;
    font-weight: 800;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
}
.vp-btn-secondary:hover {
    background: var(--vp-primary-soft);
    border-color: var(--vp-primary);
    color: var(--vp-primary-dark);
}

.vp-trial-badge {
    background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
    color: #065F46;
    padding: 10px 14px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 10px;
}

.vp-errors {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    border-radius: 12px;
    padding: 12px 14px;
    margin-bottom: 18px;
    font-size: 13px;
    color: #B91C1C;
    list-style: none;
}
.vp-errors li { padding: 2px 0; }

.vp-footer {
    text-align: center;
    margin-top: 28px;
    font-size: 12px;
    color: var(--vp-text-3);
}
.vp-footer a { color: var(--vp-primary); font-weight: 700; text-decoration: none; }
.vp-footer a:hover { text-decoration: underline; }

@media (max-width: 480px) {
    .vp-login-card { padding: 32px 24px; }
    .vp-login-title { font-size: 22px; }
}
</style>
@endpush

@section('app-content')
<div class="vp-login-page">
    <div class="vp-login-wrap">
        <div class="vp-login-card">

            <div class="vp-logo-wrap">
                <a href="/"><img src="/images/val-logo-dark.png" alt="Val Solutions"></a>
            </div>

            <div class="vp-welcome-icon">👋</div>

            <h1 class="vp-login-title">أهلاً بك مجدّداً</h1>
            <p class="vp-login-subtitle">سجّل دخولك للوحة تحكّمك</p>

            @if($errors->any())
            <ul class="vp-errors">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
            @endif

            <form method="POST" action="{{ route('user.login') }}">
                @csrf

                <div class="vp-form-group">
                    <label class="vp-form-label">البريد الإلكتروني أو اسم المستخدم</label>
                    <div class="vp-input-wrap">
                        <span class="vp-input-icon">📧</span>
                        <input type="text" name="username" class="vp-form-input" 
                               placeholder="ahmed@example.com"
                               value="{{ old('username') }}" required autofocus>
                    </div>
                </div>

                <div class="vp-form-group">
                    <label class="vp-form-label">كلمة المرور</label>
                    <div class="vp-input-wrap">
                        <span class="vp-input-icon">🔒</span>
                        <input type="password" name="password" class="vp-form-input" 
                               placeholder="••••••••" required>
                    </div>
                </div>

                <div class="vp-form-options">
                    <label class="vp-remember">
                        <input type="checkbox" name="remember">
                        تذكّرني
                    </label>
                    <a href="{{ route('user.password.request') }}" class="vp-forgot-link">
                        نسيت كلمة المرور؟
                    </a>
                </div>

                <button type="submit" class="vp-btn-primary">
                    <span>🔐</span>
                    <span>تسجيل الدخول</span>
                </button>
            </form>

            <div class="vp-divider"><span>أو</span></div>

            <p class="vp-signup-text">ليس لديك حساب؟</p>
            <a href="{{ route('user.register') }}" class="vp-btn-secondary">
                <span>✨</span>
                <span>اشترك مجاناً — ١٤ يوم تجربة</span>
            </a>

            <div class="vp-footer">
                بالدخول، أنت توافق على
                <a href="/policy/terms">الشروط والأحكام</a>
                و
                <a href="/policy/privacy">سياسة الخصوصيّة</a>
            </div>
        </div>
    </div>
</div>
@endsection
