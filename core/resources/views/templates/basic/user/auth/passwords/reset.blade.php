@extends($activeTemplate.'layouts.app')

@push('style')
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Cairo', sans-serif !important; background: #F9FAFB; }

:root {
    --vp-500: #6366F1; --vp-600: #4F46E5; --vp-700: #4338CA; --vp-800: #3730A3;
    --vp-50: #EEF2FF; --vp-100: #E0E7FF;
    --g-50: #F9FAFB; --g-100: #F2F4F7; --g-200: #EAECF0;
    --g-400: #98A2B3; --g-500: #667085; --g-600: #475467;
    --g-700: #344054; --g-900: #101828;
    --success-50: #ECFDF3; --success-500: #12B76A; --success-600: #039855;
}

.vp-auth-page { min-height: 100vh; display: flex; direction: rtl; }
.vp-auth-left {
    flex: 1; background: linear-gradient(135deg, #4F46E5 0%, #4338CA 50%, #312E81 100%);
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
    font-size: 36px; font-weight: 900; margin-bottom: 14px; letter-spacing: -0.8px;
}
.vp-auth-hero p { font-size: 16px; line-height: 1.7; color: rgba(255,255,255,0.85); max-width: 460px; }
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
.vp-auth-form .form-group { margin-bottom: 16px; }
.vp-auth-form label {
    display: block; font-size: 13px; font-weight: 700; color: var(--g-700); margin-bottom: 6px;
}
.input-wrap { position: relative; }
.vp-auth-form input[type="password"],
.vp-auth-form input[type="text"] {
    width: 100%; padding: 13px 16px; padding-left: 44px;
    border: 1.5px solid var(--g-200); border-radius: 10px;
    font-family: 'Cairo', sans-serif; font-size: 14px;
    color: var(--g-900); background: white; transition: all 0.15s; direction: rtl;
}
.vp-auth-form input:focus {
    outline: none; border-color: var(--vp-600);
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}
.toggle-pwd {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer; color: var(--g-400);
    padding: 4px;
}
.toggle-pwd:hover { color: var(--vp-600); }

.vp-pwd-strength {
    margin-top: 14px; padding: 14px; background: var(--g-50);
    border-radius: 12px; font-size: 12.5px; border: 1px solid var(--g-100);
}
.vp-pwd-strength-title {
    font-weight: 700; color: var(--g-700); margin-bottom: 8px;
    font-size: 12px;
}
.vp-pwd-strength-item {
    display: flex; align-items: center; gap: 8px;
    color: var(--g-500); padding: 3px 0; font-weight: 600;
    transition: color 0.2s;
}
.vp-pwd-strength-item.ok { color: var(--success-600); }
.vp-check-icon {
    width: 18px; height: 18px; border-radius: 50%;
    background: var(--g-200); color: var(--g-500);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 10px; transition: all 0.2s;
    flex-shrink: 0;
}
.vp-pwd-strength-item.ok .vp-check-icon {
    background: var(--success-500); color: white;
}

.vp-auth-btn {
    width: 100%; padding: 14px; margin-top: 6px;
    background: linear-gradient(135deg, var(--vp-500), var(--vp-700));
    color: white; font-family: 'Cairo', sans-serif;
    font-size: 15px; font-weight: 800; border: none; border-radius: 10px;
    cursor: pointer; transition: all 0.2s;
    box-shadow: 0 8px 20px -4px rgba(79, 70, 229, 0.35);
}
.vp-auth-btn:hover { box-shadow: 0 12px 28px -4px rgba(79, 70, 229, 0.5); transform: translateY(-2px); }
.vp-auth-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none !important; box-shadow: 0 4px 8px rgba(79,70,229,0.2) !important; }

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

    <div class="vp-auth-left">
        <div class="vp-auth-brand">
            <img src="{{ asset('images/val-logo.png') }}" alt="Val POS" onerror="this.style.display='none'">
            <span style="font-size: 22px; font-weight: 900;">Val POS</span>
        </div>

        <div class="vp-auth-hero">
            <h2>كلمة مرور قويّة، حساب آمن</h2>
            <p>اختر كلمة مرور قويّة ومميّزة لحماية بيانات متجرك وعملائك من أيّ اختراق.</p>
        </div>

        <div class="vp-auth-features">
            <div class="vp-auth-feat">
                <span class="vp-auth-feat-icon">🔒</span>
                <span>تشفير قويّ بمستوى البنوك</span>
            </div>
            <div class="vp-auth-feat">
                <span class="vp-auth-feat-icon">✅</span>
                <span>استخدم 8 أحرف أو أكثر</span>
            </div>
            <div class="vp-auth-feat">
                <span class="vp-auth-feat-icon">🔑</span>
                <span>اجمع بين أحرف وأرقام ورموز</span>
            </div>
        </div>
    </div>

    <div class="vp-auth-right">
        <div class="vp-auth-card">

            <div class="vp-auth-icon">🔑</div>

            <h1 class="vp-auth-title">كلمة مرور جديدة</h1>
            <p class="vp-auth-subtitle">اختر كلمة مرور قويّة لتأمين حسابك</p>

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="vp-error">⚠ {{ $error }}</div>
                @endforeach
            @endif

            <form action="{{ route('user.password.update') }}" method="POST" class="vp-auth-form" id="reset-form">
                @csrf
                <input type="hidden" name="email" value="{{ $email ?? '' }}">
                <input type="hidden" name="token" value="{{ $token ?? '' }}">

                <div class="form-group">
                    <label for="password">كلمة المرور الجديدة</label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="password"
                               placeholder="••••••••" required minlength="6">
                        <button type="button" class="toggle-pwd" data-target="password">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">تأكيد كلمة المرور</label>
                    <div class="input-wrap">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               placeholder="••••••••" required minlength="6">
                        <button type="button" class="toggle-pwd" data-target="password_confirmation">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="vp-pwd-strength">
                    <div class="vp-pwd-strength-title">متطلّبات كلمة المرور:</div>
                    <div class="vp-pwd-strength-item" id="rule-length">
                        <span class="vp-check-icon">✓</span>
                        <span>8 أحرف على الأقل</span>
                    </div>
                    <div class="vp-pwd-strength-item" id="rule-upper">
                        <span class="vp-check-icon">✓</span>
                        <span>حرف كبير واحد على الأقل (A-Z)</span>
                    </div>
                    <div class="vp-pwd-strength-item" id="rule-number">
                        <span class="vp-check-icon">✓</span>
                        <span>رقم واحد على الأقل (0-9)</span>
                    </div>
                    <div class="vp-pwd-strength-item" id="rule-match">
                        <span class="vp-check-icon">✓</span>
                        <span>تطابق كلمة المرور</span>
                    </div>
                </div>

                <button type="submit" class="vp-auth-btn" id="submit-btn" disabled>
                    تعيين كلمة المرور الجديدة
                </button>
            </form>

        </div>
    </div>

</div>
@endsection

@push('script')
<script>
(function() {
    const pwd = document.getElementById('password');
    const conf = document.getElementById('password_confirmation');
    const btn = document.getElementById('submit-btn');

    function check() {
        const p = pwd.value;
        const c = conf.value;

        const r1 = p.length >= 8;
        const r2 = /[A-Z]/.test(p);
        const r3 = /[0-9]/.test(p);
        const r4 = p && p === c;

        document.getElementById('rule-length').classList.toggle('ok', r1);
        document.getElementById('rule-upper').classList.toggle('ok', r2);
        document.getElementById('rule-number').classList.toggle('ok', r3);
        document.getElementById('rule-match').classList.toggle('ok', r4);

        btn.disabled = !(r1 && r2 && r3 && r4);
    }

    pwd.addEventListener('input', check);
    conf.addEventListener('input', check);

    // Toggle password visibility
    document.querySelectorAll('.toggle-pwd').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = document.getElementById(this.dataset.target);
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    });
})();
</script>
@endpush
