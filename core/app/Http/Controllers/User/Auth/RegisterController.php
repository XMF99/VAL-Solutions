<?php
namespace App\Http\Controllers\User\Auth;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\Intended;
use App\Models\AdminNotification;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserLogin;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function showRegistrationForm(Request $request)
    {
        $reference = $request->reference;

        $planSlug = $request->plan ?? 'basic';
        $planMap = [
            'basic' => 1,
            'advanced' => 2,
            'professional' => 3,
            'enterprise' => 4,
        ];
        $selectedPlanId = $planMap[$planSlug] ?? 1;

        $pageTitle = 'إنشاء حساب جديد';
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        $plans = SubscriptionPlan::where('status', 1)->orderBy('id')->get();
        $selectedPlan = $plans->firstWhere('id', $selectedPlanId) ?? $plans->first();

        return view('Template::user.auth.register', compact(
            'pageTitle', 'mobileCode', 'countries', 'reference',
            'plans', 'selectedPlan', 'planSlug'
        ));
    }

    public function register(Request $request)
    {
        if (!gs('registration')) {
            $notify[] = ['error', 'Registration not allowed'];
            return back()->withNotify($notify);
        }
        $this->validator($request->all())->validate();
        $request->session()->regenerateToken();
        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        // Map plan_slug to plan_id
        $planMap = [
            'basic' => 1,
            'advanced' => 2,
            'professional' => 3,
            'enterprise' => 4,
        ];
        $planSlug = $request->plan_slug ?? 'basic';
        $planId = $planMap[$planSlug] ?? 1;
        $plan = SubscriptionPlan::find($planId);

        // Generate unique username
        $username = Str::slug($request->firstname . '-' . $request->lastname . '-' . substr(md5(time() . rand()), 0, 4));

        $user = new User();
        $user->firstname        = $request->firstname;
        $user->lastname         = $request->lastname;
        $user->username         = $username;
        $user->email            = strtolower(trim($request->email));
        $user->password         = Hash::make($request->password);
        $user->mobile           = $request->mobile_code . $request->mobile;
        $user->dial_code        = $request->mobile_code;
        $user->business_name    = $request->business_name ?? null;
        $user->country_name     = 'Saudi Arabia';
        $user->country_code     = 'SA';
        $user->status           = 1;
        $user->ev               = 0;
        $user->sv               = 1;
        $user->tv               = 1;
        $user->profile_complete = 1;
        $user->plan_id          = $planId;
        $user->plan_expired_at  = Carbon::now()->addDays(14);

        if ($plan) {
            $user->product_limit   = $plan->product_limit;
            $user->user_limit      = $plan->user_limit;
            $user->warehouse_limit = $plan->warehouse_limit;
            $user->supplier_limit  = $plan->supplier_limit;
            $user->coupon_limit    = $plan->coupon_limit;
            $user->hrm_access      = $plan->hrm_access;
        }

        $user->save();

        event(new Registered($user));
        $this->guard()->login($user);

        // Send OTP code to email
        $user->ver_code = verificationCode(6);
        $user->ver_code_send_at = Carbon::now();
        $user->save();

        try {
            notify($user, 'EVER_CODE', ['code' => $user->ver_code], ['email']);
        } catch (\Exception $e) {
            Log::error('OTP email failed: ' . $e->getMessage());
        }

        return redirect()->route('user.authorization');
    }

    public function checkUser(Request $request)
    {
        $exist['data'] = false;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data'] = User::where('email', $request->email)->exists();
            $exist['type'] = 'email';
        } elseif ($request->mobile) {
            $exist['data'] = User::where('mobile', $request->mobile)->exists();
            $exist['type'] = 'mobile';
        } elseif ($request->username) {
            $exist['data'] = User::where('username', $request->username)->exists();
            $exist['type'] = 'username';
        }
        return response($exist);
    }

    protected function validator(array $data)
    {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        $agree = 'nullable';
        if (gs('agree')) {
            $agree = 'required';
        }
        $validate = Validator::make($data, [
            'firstname'     => 'required|string|max:60',
            'lastname'      => 'required|string|max:60',
            'business_name' => 'required|string|max:120',
            'email'         => 'required|string|email|max:60|unique:users',
            'mobile'        => 'required|string|max:20',
            'password'      => ['required', 'confirmed', $passwordValidation],
            'captcha'       => 'sometimes|required',
            'agree'         => $agree
        ]);
        return $validate;
    }

    public function registered()
    {
        return to_route('user.authorization');
    }
}
