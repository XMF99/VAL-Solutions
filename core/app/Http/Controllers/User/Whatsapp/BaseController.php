<?php

namespace App\Http\Controllers\User\Whatsapp;

use App\Models\User;
use App\Models\WhatsappStoreSetting;
use App\Services\WhatsappService;
use Illuminate\Routing\Controller as IlluminateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

abstract class BaseController extends IlluminateController
{
    protected WhatsappService $whatsappService;
    protected ?User $merchant = null;
    protected ?WhatsappStoreSetting $setting = null;

    public function __construct(WhatsappService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function callAction($method, $parameters)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/user/login')->with('error', 'يرجى تسجيل الدخول');
        }

        // ✨ تجربة مستخدم: بدل abort 403، نعرض صفحة ترقية جميلة
        if (($user->plan_id ?? 0) < 3) {
            return response()->view('user.whatsapp.upgrade', [
                'pageTitle' => 'الترقية للباقة الشاملة',
                'currentPlanId' => $user->plan_id ?? 0,
            ]);
        }

        $this->merchant = $user;
        $this->setting = WhatsappStoreSetting::firstOrCreate(['user_id' => $user->id]);

        View::share('merchant', $this->merchant);
        View::share('setting', $this->setting);
        View::share('isConnected', $this->setting->isConnected());
        View::share('pageTitle', 'متجر الواتس اب');

        return parent::callAction($method, $parameters);
    }
}
