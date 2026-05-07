<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ __('إنشاء حساب جديد') }} — {{ gs('site_name') }}</title>
<link rel="shortcut icon" type="image/png" href="{{ siteFavicon() }}">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Tajawal', sans-serif; background: linear-gradient(180deg, #DBEAFE 0%, #E0F2FE 25%, #F0F9FF 60%, #F8FAFC 100%); background-attachment: fixed; color: #0F172A; line-height: 1.6; min-height: 100vh; display: flex; flex-direction: column; overflow-x: hidden; }
a { color: inherit; text-decoration: none; }
@keyframes float-slow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
@keyframes border-rotate { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
@keyframes fade-up { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
.bg-decoration { position: fixed; border-radius: 50%; filter: blur(80px); pointer-events: none; z-index: 0; }
.bg-circle-1 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(59, 130, 246, 0.15), transparent); top: -100px; left: -100px; animation: float-slow 20s ease-in-out infinite; }
.bg-circle-2 { width: 400px; height: 400px; background: radial-gradient(circle, rgba(125, 211, 252, 0.2), transparent); top: 30%; right: -50px; }
.top-nav { padding: 24px 0; position: relative; z-index: 2; }
.nav-wrap { max-width: 1200px; margin: 0 auto; padding: 0 24px; display: flex; justify-content: space-between; align-items: center; }
.logo svg { width: 80px; height: 22px; fill: #0F172A; }
.back-link { font-size: 14px; color: rgba(15, 23, 42, 0.65); transition: color 0.2s; font-weight: 500; }
.back-link:hover { color: #1E40AF; }
.auth-wrap { flex: 1; display: flex; align-items: center; justify-content: center; padding: 20px 20px 40px; position: relative; z-index: 1; }
.split-card { display: grid; grid-template-columns: 1fr 1.2fr; gap: 0; max-width: 920px; width: 100%; background: rgba(255,255,255,0.85); backdrop-filter: blur(16px); border: 1px solid rgba(15, 23, 42, 0.08); border-radius: 24px; overflow: hidden; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.06); opacity: 0; animation: fade-up 0.6s ease forwards; }
.benefits-side { background: linear-gradient(160deg, #1E40AF 0%, #0369A1 100%); padding: 48px 36px; color: white; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; }
.benefits-side::before { content: ''; position: absolute; top: -50%; right: -30%; width: 80%; height: 200%; background: radial-gradient(circle, rgba(110, 231, 183, 0.2), transparent); }
.badge-side { position: relative; display: inline-flex; align-items: center; gap: 6px; font-size: 11px; color: #BAE6FD; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); padding: 5px 14px; border-radius: 100px; font-weight: 700; margin-bottom: 20px; letter-spacing: 1px; width: fit-content; }
.benefits-side h2 { position: relative; font-size: 28px; font-weight: 900; line-height: 1.25; margin-bottom: 14px; }
.benefits-side p { position: relative; font-size: 14px; color: rgba(255,255,255,0.8); line-height: 1.7; margin-bottom: 28px; }
.benefit-list { position: relative; list-style: none; }
.benefit-list li { padding: 8px 0; font-size: 13px; color: rgba(255,255,255,0.92); display: flex; align-items: flex-start; gap: 10px; }
.benefit-list .check { flex-shrink: 0; width: 20px; height: 20px; background: rgba(255,255,255,0.18); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; color: #BAE6FD; margin-top: 2px; }
.trial-tag { position: relative; margin-top: 24px; padding: 14px 16px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; font-size: 13px; color: rgba(255,255,255,0.95); display: flex; align-items: center; gap: 10px; }
.trial-tag .free-icon { width: 32px; height: 32px; background: rgba(110, 231, 183, 0.25); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 800; color: #6EE7B7; flex-shrink: 0; }
.trial-tag strong { display: block; color: white; margin-bottom: 1px; }
.form-side { padding: 40px 36px; display: flex; flex-direction: column; justify-content: center; }
.form-header { margin-bottom: 22px; }
.form-badge { display: inline-flex; font-size: 11px; color: #1E40AF; background: rgba(30, 64, 175, 0.08); padding: 5px 14px; border-radius: 100px; font-weight: 700; margin-bottom: 12px; letter-spacing: 1px; }
.form-side h1 { font-size: 24px; font-weight: 900; margin-bottom: 6px; color: #0F172A; }
.gradient-text { background: linear-gradient(90deg, #1E40AF 0%, #0EA5E9 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.form-side .subtitle { font-size: 13px; color: rgba(15, 23, 42, 0.6); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.form-group { margin-bottom: 12px; }
.form-group label { display: block; font-size: 12px; font-weight: 700; margin-bottom: 5px; color: #0F172A; }
.form-group label .req { color: #EF4444; }
.input-wrap { position: relative; }
.form-group input { width: 100%; padding: 11px 14px; border: 1.5px solid rgba(15, 23, 42, 0.1); border-radius: 10px; font-family: inherit; font-size: 13px; background: white; color: #0F172A; transition: all 0.2s; }
.form-group input:focus { outline: none; border-color: #1E40AF; box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1); }
.form-group input.error { border-color: #EF4444; background: #FEF2F2; }
.error-msg { color: #EF4444; font-size: 11px; margin-top: 3px; font-weight: 500; }
.toggle-pw { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: rgba(15, 23, 42, 0.5); padding: 4px; font-size: 11px; font-weight: 600; font-family: inherit; }
.help-text { font-size: 11px; color: rgba(15, 23, 42, 0.5); margin-top: 3px; }
.terms-wrap { display: flex; align-items: flex-start; gap: 8px; margin: 12px 0 16px; padding: 10px 12px; background: rgba(30, 64, 175, 0.04); border-radius: 10px; }
.terms-wrap input { width: 16px; height: 16px; margin-top: 2px; cursor: pointer; accent-color: #1E40AF; flex-shrink: 0; }
.terms-wrap label { font-size: 12px; color: rgba(15, 23, 42, 0.7); line-height: 1.6; cursor: pointer; }
.terms-wrap a { color: #1E40AF; font-weight: 600; }
.submit-btn { position: relative; width: 100%; padding: 13px; background: #0F172A; color: white; border: 2px solid transparent; border-radius: 12px; font-family: inherit; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; overflow: hidden; z-index: 1; }
.submit-btn::before { content: ''; position: absolute; inset: -2px; border-radius: 12px; background: conic-gradient(from 0deg, #3B82F6, #06B6D4, #0EA5E9, #38BDF8, #3B82F6); z-index: -2; animation: border-rotate 4s linear infinite; }
.submit-btn::after { content: ''; position: absolute; inset: 2px; border-radius: 10px; background: #0F172A; z-index: -1; }
.submit-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(59, 130, 246, 0.25); }
.form-footer { text-align: center; padding-top: 14px; margin-top: 14px; border-top: 1px solid rgba(15, 23, 42, 0.06); font-size: 13px; color: rgba(15, 23, 42, 0.65); }
.form-footer a { color: #1E40AF; font-weight: 700; }
.alert { padding: 10px 14px; border-radius: 10px; font-size: 12px; font-weight: 500; margin-bottom: 12px; }
.alert-error { background: #FEF2F2; color: #B91C1C; border: 1px solid #FECACA; }
.bottom-bar { padding: 16px 0; text-align: center; font-size: 12px; color: rgba(15, 23, 42, 0.5); position: relative; z-index: 2; }
@media (max-width: 768px) { .split-card { grid-template-columns: 1fr; max-width: 480px; } .benefits-side { padding: 32px 24px; } .benefits-side h2 { font-size: 22px; } .form-side { padding: 28px 24px; } .form-row { grid-template-columns: 1fr; gap: 0; } }
</style>
</head>
<body>

<div class="bg-decoration bg-circle-1"></div>
<div class="bg-decoration bg-circle-2"></div>

<header class="top-nav">
  <div class="nav-wrap">
    <a href="{{ route('home') }}" class="logo">
      <svg viewBox="0 0 629 181"><g transform="translate(-498.584868,301.182831) scale(0.1,-0.1)"><path d="M4986 2998 c4 -7 107 -173 229 -368 122 -195 333 -535 470 -755 211 -339 259 -411 319 -470 216 -214 526 -263 805 -129 77 38 108 60 175 127 68 69 106 122 236 332 389 629 443 712 480 746 47 43 113 64 175 56 53 -8 112 -36 141 -69 12 -12 126 -192 254 -398 128 -206 303 -486 388 -622 l154 -248 274 0 c151 0 274 2 274 5 0 3 -96 159 -213 348 -118 188 -312 500 -432 692 -272 438 -291 469 -335 521 -78 94 -214 181 -345 220 -45 14 -93 18 -190 18 -113 0 -140 -4 -208 -26 -43 -14 -110 -45 -150 -69 -135 -80 -171 -126 -512 -674 -291 -466 -315 -502 -360 -530 -42 -26 -58 -30 -119 -30 -121 1 -144 21 -289 254 -275 440 -636 1019 -652 1049 l-19 32 -279 0 c-220 0 -277 -3 -271 -12z"/><path d="M8741 2973 c13 -21 176 -283 362 -583 187 -300 389 -626 451 -725 143 -233 226 -321 367 -389 156 -75 169 -76 804 -76 l556 0 -2 235 -1 235 -537 0 c-317 0 -550 4 -570 10 -65 18 -100 53 -175 170 -75 117 -562 898 -665 1067 l-56 92 -278 1 -279 0 23 -37z"/></g></svg>
    </a>
    <a href="{{ route('home') }}" class="back-link">← العودة للرئيسية</a>
  </div>
</header>

<main class="auth-wrap">
  <div class="split-card">

    <div class="benefits-side">
      <span class="badge-side">انضم إلى {{ gs('site_name') }}</span>
      <h2>ابدأ رحلة متجرك معنا اليوم</h2>
      <p>منصّة بيع متكاملة مصمّمة خصّيصاً للسوق السعودي. بدون رسوم خفيّة، بدون تعقيد.</p>
      <ul class="benefit-list">
        <li><span class="check">✓</span> تجربة مجانيّة ١٤ يوم</li>
        <li><span class="check">✓</span> بدون بطاقة ائتمان</li>
        <li><span class="check">✓</span> جاهز خلال ٥ دقائق</li>
        <li><span class="check">✓</span> دعم فنّي عربي ٢٤/٧</li>
        <li><span class="check">✓</span> فاتورة ZATCA متوافقة</li>
        <li><span class="check">✓</span> ألغِ في أيّ وقت</li>
      </ul>
      <div class="trial-tag">
        <div class="free-icon">★</div>
        <div>
          <strong>تجربة مجانيّة كاملة</strong>
          ١٤ يوم بدون أيّ رسوم
        </div>
      </div>
    </div>

    <div class="form-side">
      <div class="form-header">
        <span class="form-badge">إنشاء حساب</span>
        <h1>أنشئ <span class="gradient-text">حسابك</span></h1>
        <p class="subtitle">عبّئ البيانات لإنشاء متجرك</p>
      </div>

      @if($errors->any())
        @foreach($errors->all() as $error)
          <div class="alert alert-error">{{ $error }}</div>
        @endforeach
      @endif

      <form method="POST" action="{{ route('user.register') }}">
        @csrf

        <div class="form-group">
          <label>اسم المتجر <span class="req">*</span></label>
          <input type="text" name="firstname" value="{{ old('firstname') }}" placeholder="متجر الأناقة" required class="@error('firstname') error @enderror">
          @error('firstname') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <input type="hidden" name="lastname" value="Store">

        <div class="form-group">
          <label>اسم المستخدم <span class="req">*</span></label>
          <input type="text" name="username" value="{{ old('username') }}" placeholder="ahmed_store" required pattern="[A-Za-z0-9_]+" class="@error('username') error @enderror">
          <p class="help-text">أحرف إنجليزيّة وأرقام فقط</p>
          @error('username') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label>البريد الإلكتروني <span class="req">*</span></label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="store@example.com" required class="@error('email') error @enderror">
          @error('email') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label>رقم الجوال <span class="req">*</span></label>
          <input type="tel" name="mobile" value="{{ old('mobile') }}" placeholder="0500000000" required class="@error('mobile') error @enderror">
          @error('mobile') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <input type="hidden" name="country" value="Saudi Arabia">
        <input type="hidden" name="country_code" value="SA">
        <input type="hidden" name="mobile_code" value="966">

        <div class="form-group">
          <label>كلمة المرور <span class="req">*</span></label>
          <div class="input-wrap">
            <input type="password" id="password" name="password" placeholder="٨ أحرف على الأقل" required minlength="8" class="@error('password') error @enderror">
            <button type="button" class="toggle-pw" onclick="togglePw('password', this)">عرض</button>
          </div>
          @error('password') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <input type="hidden" name="password_confirmation" id="password_confirmation">

        <div class="terms-wrap">
          <input type="checkbox" id="agree" name="agree" required>
          <label for="agree">
            أوافق على <a href="#">شروط الاستخدام</a> و<a href="#">سياسة الخصوصيّة</a>
          </label>
        </div>

        <button type="submit" class="submit-btn">إنشاء الحساب وبدء التجربة</button>
      </form>

      <div class="form-footer">
        لديك حساب بالفعل؟ <a href="{{ route('user.login') }}">سجّل الدخول</a>
      </div>
    </div>

  </div>
</main>

<footer class="bottom-bar">
  © 2026 {{ gs('site_name') }} — جميع الحقوق محفوظة
</footer>

<script>
function togglePw(id, btn) {
  const input = document.getElementById(id);
  if (input.type === 'password') { input.type = 'text'; btn.textContent = 'إخفاء'; }
  else { input.type = 'password'; btn.textContent = 'عرض'; }
}

// Sync password_confirmation with password (since OvoSale may require it)
document.getElementById('password').addEventListener('input', function() {
  document.getElementById('password_confirmation').value = this.value;
});
</script>

</body>
</html>
