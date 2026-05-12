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
}
.vp-otp * { box-sizing: border-box; }
.vp-otp {
    font-family: 'Cairo', 'Tajawal', system-ui, sans-serif !important;
    direction: rtl;
    background: linear-gradient(135deg, #F5F7FE 0%, #EEF2FF 100%);
    min-height: 100vh;
    padding: 60px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.vp-otp-card {
    background: white;
    border-radius: 24px;
    padding: 48px 36px;
    max-width: 480px;
    width: 100%;
    box-shadow: 0 24px 60px rgba(79, 70, 229, 0.12);
    text-align: center;
    border: 1px solid rgba(79, 70, 229, 0.08);
}
.vp-otp-logo { margin-bottom: 24px; }
.vp-otp-logo img { height: 36px; }
.vp-otp-icon {
    width: 88px;
    height: 88px;
    background: linear-gradient(135deg, var(--vp-primary-light), var(--vp-primary-soft));
    border-radius: 24px;
    margin: 0 auto 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 42px;
    box-shadow: 0 8px 20px rgba(79, 70, 229, 0.15);
}
.vp-otp-title {
    font-family: 'Cairo', sans-serif;
    font-size: 26px;
    font-weight: 900;
    color: var(--vp-text);
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}
.vp-otp-sub {
    color: var(--vp-text-2);
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 4px;
}
.vp-otp-email {
    font-weight: 800;
    color: var(--vp-primary);
    font-size: 15px;
    margin-bottom: 32px;
    direction: ltr;
}
.vp-otp-inputs {
    display: flex;
    gap: 10px;
    justify-content: center;
    direction: ltr;
    margin-bottom: 28px;
}
.vp-otp-box {
    width: 52px;
    height: 60px;
    border: 2px solid #E5E7EB;
    border-radius: 14px;
    background: #F9FAFB;
    text-align: center;
    font-size: 28px;
    font-weight: 800;
    color: var(--vp-text);
    font-family: 'Cairo', sans-serif;
    transition: all 0.2s;
    outline: none;
}
.vp-otp-box:focus {
    border-color: var(--vp-primary);
    background: white;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.18);
    transform: translateY(-2px);
}
.vp-otp-box.filled {
    border-color: var(--vp-primary);
    background: var(--vp-primary-light);
    color: var(--vp-primary);
}
.vp-otp-submit {
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
    box-shadow: 0 8px 24px rgba(79, 70, 229, 0.35);
    margin-bottom: 24px;
}
.vp-otp-submit:hover:not(:disabled) {
    background: var(--vp-primary-dark);
    transform: translateY(-2px);
}
.vp-otp-submit:disabled { opacity: 0.5; cursor: not-allowed; }
.vp-otp-resend {
    font-size: 13px;
    color: var(--vp-text-3);
    margin-bottom: 8px;
}
.vp-otp-resend-btn {
    color: var(--vp-primary);
    font-weight: 800;
    background: none;
    border: none;
    cursor: pointer;
    font-family: inherit;
    font-size: 13px;
}
.vp-otp-resend-btn:disabled { color: #A3A3A3; cursor: not-allowed; }
.vp-otp-timer { color: var(--vp-primary); font-weight: 700; }
.vp-otp-footer {
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid #F5F5F0;
    font-size: 12px;
    color: var(--vp-text-3);
    line-height: 1.7;
}
.vp-otp-footer a { color: var(--vp-primary); text-decoration: none; font-weight: 700; }
.vp-errors {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    border-radius: 10px;
    padding: 10px 14px;
    margin-bottom: 18px;
    font-size: 13px;
    color: #B91C1C;
    list-style: none;
}
@media (max-width: 480px) {
    .vp-otp-card { padding: 36px 24px; }
    .vp-otp-title { font-size: 22px; }
    .vp-otp-box { width: 44px; height: 54px; font-size: 24px; }
    .vp-otp-inputs { gap: 6px; }
}
</style>
@endpush

@section('app-content')
<div class="vp-otp">
    <div class="vp-otp-card">
        <a href="/" class="vp-otp-logo"><img src="/images/val-logo-dark.png" alt="Val Solutions"></a>
        <div class="vp-otp-icon">📬</div>
        <h1 class="vp-otp-title">تحقّق من بريدك الإلكتروني</h1>
        <p class="vp-otp-sub">أرسلنا رمز التفعيل المكوّن من ٦ أرقام إلى:</p>
        <div class="vp-otp-email">{{ $user->email ?? '' }}</div>

        @if($errors->any())
        <ul class="vp-errors">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

        <form method="POST" action="{{ route('user.verify.email') }}" id="otpForm">
            @csrf
            <div class="vp-otp-inputs">
                @for($i = 0; $i < 6; $i++)
                <input type="text" class="vp-otp-box" maxlength="1" inputmode="numeric" data-index="{{ $i }}" {{ $i == 0 ? 'autofocus' : '' }}>
                @endfor
            </div>
            <input type="hidden" name="code" id="otpCode">
            <button type="submit" class="vp-otp-submit" id="submitBtn" disabled>✓ تأكيد الرمز</button>
        </form>

        <p class="vp-otp-resend">
            لم يصلك الرمز؟ 
            <button type="button" class="vp-otp-resend-btn" id="resendBtn" disabled>إعادة إرسال</button>
            <span class="vp-otp-timer" id="timer">(00:60)</span>
        </p>

        <div class="vp-otp-footer">
            📧 لم يصل البريد؟ تحقّق من <strong>Spam</strong>
            <br>
            <a href="{{ route('user.logout') }}">← غيّر البريد الإلكتروني</a>
        </div>
    </div>
</div>

<script>
(function() {
    const boxes = document.querySelectorAll('.vp-otp-box');
    const submitBtn = document.getElementById('submitBtn');
    const otpCodeInput = document.getElementById('otpCode');
    const resendBtn = document.getElementById('resendBtn');
    const timerEl = document.getElementById('timer');
    
    boxes.forEach((box, i) => {
        box.addEventListener('input', function(e) {
            const v = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = v;
            if (v) {
                e.target.classList.add('filled');
                if (i < boxes.length - 1) boxes[i + 1].focus();
            } else {
                e.target.classList.remove('filled');
            }
            updateOTP();
        });
        box.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !e.target.value && i > 0) boxes[i - 1].focus();
        });
        box.addEventListener('paste', function(e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            const digits = pasted.replace(/[^0-9]/g, '').slice(0, 6).split('');
            digits.forEach((d, j) => {
                if (boxes[j]) { boxes[j].value = d; boxes[j].classList.add('filled'); }
            });
            updateOTP();
        });
    });
    
    function updateOTP() {
        const code = Array.from(boxes).map(b => b.value).join('');
        otpCodeInput.value = code;
        submitBtn.disabled = code.length !== 6;
    }
    
    let seconds = 60;
    function updateTimer() {
        if (seconds > 0) {
            const m = String(Math.floor(seconds / 60)).padStart(2, '0');
            const s = String(seconds % 60).padStart(2, '0');
            timerEl.textContent = `(${m}:${s})`;
            seconds--;
        } else {
            clearInterval(timerInterval);
            timerEl.textContent = '';
            resendBtn.disabled = false;
        }
    }
    const timerInterval = setInterval(updateTimer, 1000);
    updateTimer();
    
    resendBtn.addEventListener('click', function() {
        window.location.href = '{{ route("user.send.verify.code", "email") }}';
    });
})();
</script>
@endsection
