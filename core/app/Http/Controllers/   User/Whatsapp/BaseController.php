
<?php

namespace App\Http\Controllers\User\Whatsapp;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WhatsappStoreSetting;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\Auth;

/**
 * Base Controller — متجر واتساب
 * 
 * يفحص:
 * 1. تسجيل دخول التاجر
 * 2. الباقة الثالثة (plan_id >= 3)
 * 3. تحميل/إنشاء WhatsappStoreSetting تلقائياً
 */
abstract class BaseController extends Controller
{
    protected WhatsappService $whatsappService;
    protected ?User $merchant = null;
    protected ?WhatsappStoreSetting $setting = null;

    public function __construct(WhatsappService $whatsappService)
    {
        $this->whatsappService = $whatsappService;

        $this->middleware(function ($request, $next) {
            // 1. التحقّق من تسجيل الدخول
            if (!Auth::check()) {
                return redirect()->route('user.login')
                    ->with('error', 'يرجى تسجيل الدخول');
            }

            $this->merchant = Auth::user();

            // 2. التحقّق من الباقة الثالثة
            if (!$this->whatsappService->hasWhatsappPlan($this->merchant)) {
                return redirect()->route('user.home')
                    ->with('error', 'هذه الميزة متاحة للباقة الثالثة فقط — يرجى الترقية');
            }

            // 3. تحميل أو إنشاء إعدادات الواتساب
            $this->setting = $this->merchant->whatsappSetting 
                ?? WhatsappStoreSetting::create([
                    'user_id' => $this->merchant->id,
                    'store_slug' => 'store-' . $this->merchant->id,
                    'store_name' => $this->merchant->fullname ?? $this->merchant->username ?? 'متجري',
                    'is_active' => false,
                ]);

            // 4. مشاركة المتغيّرات لكلّ الـ Views
            view()->share([
                'whatsappMerchant' => $this->merchant,
                'whatsappSetting' => $this->setting,
            ]);

            return $next($request);
        });
    }
}
