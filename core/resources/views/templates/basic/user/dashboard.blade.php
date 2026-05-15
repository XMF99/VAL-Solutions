@extends($activeTemplate . 'layouts.master')

@section('panel')
<div style="padding: 30px; font-family: 'Cairo','Tajawal',sans-serif; direction: rtl;">

    <div style="background: linear-gradient(135deg, #4F46E5, #7C3AED, #EC4899); color: white; padding: 30px; border-radius: 16px; margin-bottom: 24px;">
        <h1 style="font-size: 28px; font-weight: 900; margin: 0;">
            مرحباً، {{ auth()->user()->firstname ?? auth()->user()->username }} 👋
        </h1>
        <p style="margin: 8px 0 0; opacity: 0.9;">{{ now()->format('l, d F Y') }}</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">مبيعات اليوم</div>
            <div style="font-size: 24px; font-weight: 900; color: #0F172A;">{{ number_format($widget['today_sale'] ?? 0, 2) }}</div>
        </div>
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">عدد الفواتير</div>
            <div style="font-size: 24px; font-weight: 900; color: #0F172A;">{{ $widget['today_orders_count'] ?? 0 }}</div>
        </div>
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">عدد العملاء</div>
            <div style="font-size: 24px; font-weight: 900; color: #0F172A;">{{ $widget['total_customers'] ?? 0 }}</div>
        </div>
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">عدد المنتجات</div>
            <div style="font-size: 24px; font-weight: 900; color: #0F172A;">{{ $widget['total_products'] ?? 0 }}</div>
        </div>
    </div>

    <div style="background: #EEF2FF; padding: 20px; border-radius: 12px; border: 1px solid #C7D2FE;">
        <h3 style="margin: 0 0 8px; color: #4F46E5;">🎉 الموقع جاهز!</h3>
        <p style="margin: 0; color: #4338CA;">
            السايدبار الجديد بـ16 منيو يشتغل. لوحة التحكم المفصّلة بالمخطّطات قادمة في يوم 2.
        </p>
    </div>

</div>
@endsection
