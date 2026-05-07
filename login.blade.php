<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ __('تسجيل الدخول') }} — {{ gs('site_name') }}</title>
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
.auth-wrap { flex: 1; display: flex; align-items: center; justify-content: center; padding: 20px; position: relative; z-index: 1; }
.auth-card { background: rgba(255,255,255,0.85); backdrop-filter: blur(16px); border: 1px solid rgba(15, 23, 42, 0.08); border-radius: 24px; padding: 48px 40px; max-width: 460px; width: 100%; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.06); opacity: 0; animation: fade-up 0.6s ease forwards; }
.auth-header { text-align: center; margin-bottom: 32px; }
.auth-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; color: #1E40AF; background: rgba(30, 64, 175, 0.08); padding: 5px 14px; border-radius: 100px; font-weight: 700; margin-bottom: 18px; letter-spacing: 1px; }
.auth-card h1 { font-size: 28px; font-weight: 900; margin-bottom: 8px; color: #0F172A; }
.auth-card .subtitle { font-size: 14px; color: rgba(15, 23, 42, 0.6); }
.gradient-text { background: linear-gradient(90deg, #1E40AF 0%, #0EA5E9 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.form-group { margin-bottom: 18px; }
.form-group label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #0F172A; }
.input-wrap { position: relative; }
.form-group input { width: 100%; padding: 13px 16px; border: 1.5px solid rgba(15, 23, 42, 0.1); border-radius: 12px; font-family: inherit; font-size: 14px; background: white; color: #0F172A; transition: all 0.2s; }
.form-group input:focus { outline: none; border-color: #1E40AF; box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1); }
.form-group input.error { border-color: #EF4444; background: #FEF2F2; }
.error-msg { color: #EF4444; font-size: 12px; margin-top: 4px; font-weight: 500; }
.toggle-pw { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: rgba(15, 23, 42, 0.5); padding: 4px; font-size: 13px; font-weight: 600; font-family: inherit; }
.toggle-pw:hover { color: #1E40AF; }
.form-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 8px; }
.checkbox-wrap { display: flex; align-items: center; gap: 6px; }
.checkbox-wrap input { width: 16px; height: 16px; cursor: pointer; accent-color: #1E40AF; }
.checkbox-wrap label { font-size: 13px; color: rgba(15, 23, 42, 0.7); cursor: pointer; }
.forgot-link { font-size: 13px; color: #1E40AF; font-weight: 600; }
.submit-btn { position: relative; width: 100%; padding: 14px; background: #0F172A; color: white; border: 2px solid transparent; border-radius: 12px; font-family: inherit; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 0.3s; overflow: hidden; z-index: 1; }
.submit-btn::before { content: ''; position: absolute; inset: -2px; border-radius: 12px; background: conic-gradient(from 0deg, #3B82F6, #06B6D4, #0EA5E9, #38BDF8, #3B82F6); z-index: -2; animation: border-rotate 4s linear infinite; }
.submit-btn::after { content: ''; position: absolute; inset: 2px; border-radius: 10px; background: #0F172A; z-index: -1; }
.submit-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(59, 130, 246, 0.25); }
.auth-footer { text-align: center; padding-top: 20px; border-top: 1px solid rgba(15, 23, 42, 0.06); margin-top: 20px; font-size: 14px; color: rgba(15, 23, 42, 0.65); }
.auth-footer a { color: #1E40AF; font-weight: 700; }
.alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 500; margin-bottom: 16px; }
.alert-error { background: #FEF2F2; color: #B91C1C; border: 1px solid #FECACA; }
.alert-success { background: #F0FDF4; color: #14532D; border: 1px solid #BBF7D0; }
.bottom-bar { padding: 16px 0; text-align: center; font-size: 12px; color: rgba(15, 23, 42, 0.5); position: relative; z-index: 2; }
@media (max-width: 480px) { .auth-card { padding: 32px 24px; } .auth-card h1 { font-size: 24px; } }
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
  <div class="auth-card">
    <div class="auth-header">
      <span class="auth-badge">دخول التاجر</span>
      <h1>مرحباً <span class="gradient-text">بعودتك</span></h1>
      <p class="subtitle">سجّل دخولك للوصول إلى لوحة التحكّم</p>
    </div>

    @if(session('errors'))
      @foreach($errors->all() as $error)
        <div class="alert alert-error">{{ $error }}</div>
      @endforeach
    @endif

    <form method="POST" action="{{ route('user.login') }}">
      @csrf

      <div class="form-group">
        <label>البريد الإلكتروني أو الجوال أو اسم المستخدم</label>
        <div class="input-wrap">
          <input type="text" name="username" value="{{ old('username') }}" placeholder="example@email.com" required autocomplete="username" class="@error('username') error @enderror">
        </div>
        @error('username') <div class="error-msg">{{ $message }}</div> @enderror
      </div>

      <div class="form-group">
        <label>كلمة المرور</label>
        <div class="input-wrap">
          <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password" class="@error('password') error @enderror">
          <button type="button" class="toggle-pw" onclick="togglePw('password', this)">عرض</button>
        </div>
        @error('password') <div class="error-msg">{{ $message }}</div> @enderror
      </div>

      <div class="form-row">
        <div class="checkbox-wrap">
          <input type="checkbox" id="remember" name="remember">
          <label for="remember">تذكّرني</label>
        </div>
        <a href="{{ route('user.password.request') }}" class="forgot-link">نسيت كلمة المرور؟</a>
      </div>

      <button type="submit" class="submit-btn">تسجيل الدخول</button>
    </form>

    <div class="auth-footer">
      ليس لديك حساب بعد؟ <a href="{{ route('user.register') }}">أنشئ حساباً جديداً</a>
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
</script>

</body>
</html>
