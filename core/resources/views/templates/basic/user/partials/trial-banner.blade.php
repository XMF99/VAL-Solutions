@php
    $user = auth()->user();
    $plan = $user->plan ?? null;
    $expiresAt = $user->plan_expired_at ? \Carbon\Carbon::parse($user->plan_expired_at) : null;
    $daysLeft = $expiresAt ? max(0, now()->diffInDays($expiresAt, false)) : 0;
    $isExpired = $daysLeft <= 0;
    $isWarning = $daysLeft > 0 && $daysLeft <= 5;
    $isHealthy = $daysLeft > 5;
@endphp

@if($user && $plan)
<style>
.vp-trial-banner {
    background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
    color: white;
    padding: 16px 24px;
    border-radius: 16px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);
    font-family: 'Cairo', 'Tajawal', system-ui, sans-serif;
    direction: rtl;
    position: relative;
    overflow: hidden;
}
.vp-trial-banner.warning {
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    box-shadow: 0 8px 24px rgba(245, 158, 11, 0.25);
}
.vp-trial-banner.expired {
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    box-shadow: 0 8px 24px rgba(239, 68, 68, 0.25);
}
.vp-trial-banner::before {
    content: '';
    position: absolute;
    top: -50px;
    left: -50px;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.15), transparent 70%);
    border-radius: 50%;
}

.vp-tb-left {
    display: flex;
    align-items: center;
    gap: 16px;
    flex: 1;
    z-index: 1;
}
.vp-tb-icon {
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    flex-shrink: 0;
}
.vp-tb-text { flex: 1; }
.vp-tb-title {
    font-size: 16px;
    font-weight: 800;
    margin-bottom: 4px;
    line-height: 1.3;
}
.vp-tb-sub {
    font-size: 13px;
    opacity: 0.9;
    line-height: 1.5;
}
.vp-tb-days {
    font-weight: 900;
    font-size: 17px;
}

.vp-tb-right {
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 1;
}
.vp-tb-btn {
    background: white;
    color: #4F46E5;
    padding: 11px 22px;
    border-radius: 100px;
    font-family: inherit;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}
.vp-tb-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    color: #4F46E5;
    text-decoration: none;
}
.vp-trial-banner.warning .vp-tb-btn { color: #D97706; }
.vp-trial-banner.expired .vp-tb-btn { color: #DC2626; }

.vp-tb-progress {
    position: absolute;
    bottom: 0;
    right: 0;
    left: 0;
    height: 3px;
    background: rgba(255, 255, 255, 0.2);
    overflow: hidden;
}
.vp-tb-progress-fill {
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    transition: width 0.4s ease;
}

@media (max-width: 768px) {
    .vp-trial-banner {
        flex-direction: column;
        align-items: stretch;
        padding: 16px;
        gap: 12px;
    }
    .vp-tb-right { justify-content: center; }
    .vp-tb-btn { width: 100%; justify-content: center; }
    .vp-tb-icon { width: 44px; height: 44px; font-size: 22px; }
    .vp-tb-title { font-size: 14px; }
    .vp-tb-sub { font-size: 12px; }
}
</style>

<div class="vp-trial-banner {{ $isExpired ? 'expired' : ($isWarning ? 'warning' : '') }}">
    <div class="vp-tb-left">
        <div class="vp-tb-icon">
            @if($isExpired) ⚠️
            @elseif($isWarning) ⏰
            @else 🎁
            @endif
        </div>
        <div class="vp-tb-text">
            @if($isExpired)
                <div class="vp-tb-title">انتهت تجربتك المجانيّة</div>
                <div class="vp-tb-sub">رقّ باقتك الآن لمواصلة استخدام Val POS بدون انقطاع</div>
            @elseif($isWarning)
                <div class="vp-tb-title">
                    تنبيه: متبقّي <span class="vp-tb-days">{{ $daysLeft }}</span> أيام في تجربتك
                </div>
                <div class="vp-tb-sub">رقّ باقتك ({{ $plan->name }}) لتجنّب انقطاع الخدمة</div>
            @else
                <div class="vp-tb-title">
                    🎉 تجربتك المجانيّة شغّالة — متبقّي <span class="vp-tb-days">{{ $daysLeft }}</span> يوم
                </div>
                <div class="vp-tb-sub">
                    باقتك الحاليّة: <strong>{{ $plan->name }}</strong> ({{ $plan->monthly_price }} ر.س/شهر)
                </div>
            @endif
        </div>
    </div>
    <div class="vp-tb-right">
        @if($isExpired)
            <a href="{{ route('user.home') }}/plan" class="vp-tb-btn">
                💳 ادفع الآن
            </a>
        @else
            <a href="{{ route('user.home') }}/plan" class="vp-tb-btn">
                ⚡ فعّل الباقة الآن
            </a>
        @endif
    </div>
    
    @if($daysLeft > 0)
    <div class="vp-tb-progress">
        <div class="vp-tb-progress-fill" style="width: {{ ($daysLeft / 14) * 100 }}%;"></div>
    </div>
    @endif
</div>
@endif
