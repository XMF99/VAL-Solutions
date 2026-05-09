<?php

namespace App\Http\Controllers\User\Whatsapp;

use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as IlluminateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpgradePlanController extends IlluminateController
{
    public function show(Request $request, $targetPlanId)
    {
        $user = Auth::user();
        if (!$user) return redirect('/user/login');

        $targetPlan  = SubscriptionPlan::where('status', 1)->findOrFail($targetPlanId);
        $currentPlan = $user->plan_id ? SubscriptionPlan::find($user->plan_id) : null;

        if (!$currentPlan) {
            return redirect('/user/subscription/plan/index')
                ->with('error', 'يرجى الاشتراك في باقة أولاً قبل الترقية');
        }

        if ($targetPlan->monthly_price <= $currentPlan->monthly_price) {
            return redirect('/user/subscription/plan/index')
                ->with('error', 'الباقة المختارة ليست أعلى من باقتك الحالية');
        }

        $recurringType = in_array($request->get('type'), ['monthly', 'yearly']) ? $request->get('type') : 'monthly';
        $upgradeData   = $this->calculateUpgradePrice($currentPlan, $targetPlan, $recurringType);

        $gatewayCurrency = GatewayCurrency::whereHas('method', fn($q) => $q->where('status', 1))->orderBy('id')->get();
        $pageTitle = 'ترقية الباقة';

        return view('user.whatsapp.upgrade-plan', compact(
            'pageTitle','currentPlan','targetPlan','upgradeData','gatewayCurrency','recurringType'
        ));
    }

    public function process(Request $request, $targetPlanId)
    {
        $user = Auth::user();
        if (!$user) return redirect('/user/login');

        $request->validate([
            'gateway'        => 'required',
            'currency'       => 'required',
            'recurring_type' => ['required', Rule::in(['monthly', 'yearly'])],
        ]);

        $targetPlan  = SubscriptionPlan::where('status', 1)->findOrFail($targetPlanId);
        $currentPlan = $user->plan_id ? SubscriptionPlan::find($user->plan_id) : null;

        if (!$currentPlan) return back()->with('error', 'لا توجد باقة حالية');

        $upgradeData = $this->calculateUpgradePrice($currentPlan, $targetPlan, $request->recurring_type);
        $amount      = $upgradeData['total'];

        if ($amount <= 0) return back()->with('error', 'مبلغ الترقية غير صحيح');

        $gate = GatewayCurrency::whereHas('method', fn($q) => $q->where('status', 1))
            ->where('method_code', $request->gateway)
            ->where('currency', $request->currency)
            ->first();

        if (!$gate) return back()->with('error', 'بوّابة دفع غير صالحة');

        $charge      = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable     = $amount + $charge;
        $finalAmount = $payable * $gate->rate;

        $deposit                      = new Deposit();
        $deposit->user_id             = $user->id;
        $deposit->plan_id             = $targetPlan->id;
        $deposit->plan_recurring_type = $request->recurring_type;
        $deposit->method_code         = $gate->method_code;
        $deposit->method_currency     = strtoupper($gate->currency);
        $deposit->amount              = $amount;
        $deposit->charge              = $charge;
        $deposit->rate                = $gate->rate;
        $deposit->final_amount        = $finalAmount;
        $deposit->btc_amount          = 0;
        $deposit->btc_wallet          = '';
        $deposit->trx                 = getTrx();
        $deposit->success_url         = url('/user/whatsapp');
        $deposit->failed_url          = url('/user/subscription/plan/index');
        $deposit->save();

        session()->put('Track', $deposit->trx);
        return redirect()->route('user.deposit.confirm');
    }

    private function calculateUpgradePrice($currentPlan, $targetPlan, $recurringType = 'monthly')
    {
        $isYearly     = $recurringType === 'yearly';
        $currentPrice = $isYearly ? (float) $currentPlan->yearly_price : (float) $currentPlan->monthly_price;
        $targetPrice  = $isYearly ? (float) $targetPlan->yearly_price  : (float) $targetPlan->monthly_price;

        $difference = max(0, $targetPrice - $currentPrice);
        $upgradeFee = round($difference * 0.10, 2);
        $total      = round($difference + $upgradeFee, 2);

        return [
            'current_plan_name'    => $currentPlan->name,
            'target_plan_name'     => $targetPlan->name,
            'current_price'        => $currentPrice,
            'target_price'         => $targetPrice,
            'difference'           => $difference,
            'upgrade_fee'          => $upgradeFee,
            'upgrade_fee_percent'  => 10,
            'total'                => $total,
            'recurring_type'       => $recurringType,
        ];
    }
}
