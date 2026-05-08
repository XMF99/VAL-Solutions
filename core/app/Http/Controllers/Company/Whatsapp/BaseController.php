
<?php

namespace App\Http\Controllers\Company\Whatsapp;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\WhatsappStoreSetting;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\Auth;

/**
 * Base Controller للوحة التاجر — متجر واتساب
 * - يتحقّق من تفعيل الباقة الثالثة
 * - يحمّل إعدادات التاجر تلقائياً
 * - يوفّر helpers مشتركة
 */
abstract class BaseController extends Controller
{
    protected WhatsappService $whatsappService;
    protected ?Company $company = null;
    protected ?WhatsappStoreSetting $setting = null;

    public function __construct(WhatsappService $whatsappService)
    {
        $this->whatsappService = $whatsappService;

        $this->middleware(function ($request, $next) {
            $this->company = $this->resolveCompany();
            
            if (!$this->company) {
                return redirect()->route('company.login')
                    ->with('error', 'يرجى تسجيل الدخول');
            }

            // التحقّق من الباقة الثالثة
            if (!$this->whatsappService->hasWhatsappPlan($this->company)) {
                return redirect()->route('company.dashboard')
                    ->with('error', 'هذه الميزة متاحة للباقة الثالثة فقط — يرجى الترقية');
            }

            // تحميل أو إنشاء إعدادات الواتساب
            $this->setting = $this->company->whatsappSetting 
                ?? WhatsappStoreSetting::create([
                    'company_id' => $this->company->id,
                    'store_slug' => 'store-' . $this->company->id,
                    'store_name' => $this->company->name ?? 'متجري',
                    'is_active' => false,
                ]);

            // مشاركة المتغيّرات لكلّ الـ Views
            view()->share([
                'whatsappCompany' => $this->company,
                'whatsappSetting' => $this->setting,
            ]);

            return $next($request);
        });
    }

    /**
     * تحديد الشركة الحاليّة من المستخدم المسجّل
     */
    protected function resolveCompany(): ?Company
    {
        // محاولة 1: guard 'company'
        if (Auth::guard('company')->check()) {
            $user = Auth::guard('company')->user();
            return $user instanceof Company ? $user : ($user->company ?? null);
        }

        // محاولة 2: guard 'web' مع علاقة company
        if (Auth::check()) {
            $user = Auth::user();
            if (method_exists($user, 'company') && $user->company) {
                return $user->company;
            }
            if (isset($user->company_id)) {
                return Company::find($user->company_id);
            }
        }

        return null;
    }
}
