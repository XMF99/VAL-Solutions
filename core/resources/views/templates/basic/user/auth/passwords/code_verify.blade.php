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
    margin-bottom: 28px; line-height: 1.6;
}
.vp-otp {
    display: flex; gap: 10px; justify-content: center; direction: ltr; margin-bottom: 24px;
}
.vp-otp input {
    width: 56px; height: 64px; text-align: center;
    font-size: 28px; font-weight: 800;
    border: 2px solid var(--g-200); border-radius: 12px;
    font-family: 'Cairo', sans-serif; color: var(--g-900);
    transition: all 0.2s; background: white;
}
.vp-otp input:focus {
    outline: none; border-color: var(--vp-600); transform: scale(1.05);
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}
.vp-otp input.filled {
    border-color: var(--vp-600); background: var(--vp-50);
}
.vp-auth-btn {
    width: 100%; padding: 14px;
    background: linear-gradient(135deg, var(--vp-500), var(--vp-700));
    color: white; font-family: 'Cairo', sans-serif;
    font-size: 15px; font-weight: 800; border: none; border-radius: 10px;
    cursor: pointer; transition: all 0.2s;
    box-shadow: 0 8px 20px -4px rgba(79, 70, 229, 0.35);
}
.vp-auth-btn:hover { box-shadow: 0 12px 28px -4px rgba(79, 70, 229, 0.5); transform: translateY(-2px); }
.vp-resend {
    text-align: center; margin-top: 20px; font-size: 13.5px; color: var(--g-500);
}
.vp-resend a { color: var(--vp-600); font-weight: 700; text-decoration: none; }
.vp-resend a:hover { text-decoration: underline; }
.vp-error {
    background: #FEF3F2; color: #B42318; padding: 12px 14px;
    border-radius: 10px; font-size: 13px; margin-bottom: 16px;
    border: 1px solid #FECDCA;
}
.vp-info {
    background: #EFF8FF; color: #1849A9; padding: 12px 14px;
    border-radius: 10px; font-size: 13px; margin-bottom: 16px;
    border: 1px solid #B2DDFF; text-align: center;
}
.vp-info strong { display: block; margin-top: 4px; }

@media (max-width: 991px) {
    .vp-auth-page { flex-direction: column; }
    .vp-auth-left { padding: 28px 24px; }
    .vp-auth-hero h2 { font-size: 26px; }
    .vp-auth-features { display: none; }
    .vp-otp input { width: 48px; height: 56px; font-size: 24px; }
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
            <h2>تحقّق آمن</h2>
            <p>تحقّق إضافي لحماية حسابك. أرسلنا كوداً مكوّناً من 6 أرقام إلى بريدك الإلكتروني.</p>
        </div>

        <div class="vp-auth-features">
            <div class="vp-auth-feat">
                <span class="vp-auth-feat-icon">🛡️</span>
                <span>تشفير من طرف إلى طرف</span>
            </div>
            <div class="vp-auth-feat">
                <span class="vp-auth-feat-icon">⏱️</span>
                <span>الكود صالح لمدّة 10 دقائق</span>
            </div>
            <div class="vp-auth-feat">
                <span class="vp-auth-feat-icon">🔄</span>
                <span>يمكنك طلب كود جديد إذا انتهت المدّة</span>
            </div>
        </div>
    </div>

    <div class="vp-auth-right">
        <div class="vp-auth-card">

            <div class="vp-auth-icon">🔐</div>

            <h1 class="vp-auth-title">تحقّق من الكود</h1>
            <p class="vp-auth-subtitle">
                أرسلنا كود التحقّق إلى<br>
                <strong style="color: var(--vp-600); direction: ltr; display: inline-block;">{{ $email ?? 'بريدك المسجّل' }}</strong>
            </p>

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="vp-error">⚠ {{ $error }}</div>
                @endforeach
            @endif

            <form action="{{ route('user.password.verify.code') }}" method="POST" id="otp-form">
                @csrf

                <div class="vp-otp">
                    <input type="text" maxlength="1" class="otp-input" data-pos="0" inputmode="numeric" autofocus>
                    <input type="text" maxlength="1" class="otp-input" data-pos="1" inputmode="numeric">
                    <input type="text" maxlength="1" class="otp-input" data-pos="2" inputmode="numeric">
                    <input type="text" maxlength="1" class="otp-input" data-pos="3" inputmode="numeric">
                    <input type="text" maxlength="1" class="otp-input" data-pos="4" inputmode="numeric">
                    <input type="text" maxlength="1" class="otp-input" data-pos="5" inputmode="numeric">
                </div>

                <input type="hidden" name="code" id="code-hidden">
                <input type="hidden" name="email" value="{{ $email ?? '' }}">

                <button type="submit" class="vp-auth-btn">
                    تأكيد الكود
                </button>
            </form>

            <div class="vp-resend">
                لم يصلك الكود؟
                <a href="{{ route('user.password.email') }}">إعادة الإرسال</a>
            </div>

        </div>
    </div>

</div>
@endsection

@push('script')
<script>
(function() {
    const inputs = document.querySelectorAll('.otp-input');
    const hidden = document.getElementById('code-hidden');
    const form = document.getElementById('otp-form');

    function updateHidden() {
        let code = '';
        inputs.forEach(i => code += i.value || '');
        hidden.value = code;
    }

    inputs.forEach((input, idx) => {
        input.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value) {
                this.classList.add('filled');
                if (idx < inputs.length - 1) inputs[idx + 1].focus();
            } else {
                this.classList.remove('filled');
            }
            updateHidden();
            if (hidden.value.length === 6) form.submit();
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && idx > 0) {
                inputs[idx - 1].focus();
                inputs[idx - 1].value = '';
                inputs[idx - 1].classList.remove('filled');
                updateHidden();
            }
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
            paste.split('').forEach((char, i) => {
                if (inputs[i]) {
                    inputs[i].value = char;
                    inputs[i].classList.add('filled');
                }
            });
            updateHidden();
            if (hidden.value.length === 6) form.submit();
        });
    });
})();
</script>
@endpush
