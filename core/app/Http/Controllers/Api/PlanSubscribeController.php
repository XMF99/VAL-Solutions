<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\PlanPurchase;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PlanSubscribeController extends Controller
{
    public function index()
    {
        $user               = getParentUser();
        $subscriptionPlans  = SubscriptionPlan::active()->orderBy('id', 'desc')->get();
        $activeSubscription = PlanPurchase::where('user_id', $user->id)->with('SubscriptionPlan')->latest('id')->where('subscription_plan_id', $user->plan_id)->first();

        $message[] = "Subscription plans";
        return jsonResponse('subscription_plans', 'success', $message, [
            'subscription_plans'  => $subscriptionPlans,
            'active_subscription' => $activeSubscription,
            'user'                => $user,
        ]);
    }

    public function planPurchase(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'recurring_type' => ['required', Rule::in([Status::MONTHLY, Status::YEARLY])],
        ]);

        if ($validator->fails()) {
            return jsonResponse('validation_error', 'error', $validator->errors()->all());
        }

        $plan   = SubscriptionPlan::active()->findOrFail($id);
        $amount = getPurchasePrice($plan, $request->recurring_type);
        $user   = getParentUser();

        if ($amount <= 0) {
            return $this->manageFreePlanPurchase($user, $plan);
        }

        $validator = Validator::make($request->all(), [
            'gateway'  => 'required',
            'currency' => 'required',
        ], [
            'currency.required' => 'The payment method field is required.',
        ]);

        if ($validator->fails()) {
            return jsonResponse('validation_error', 'error', $validator->errors()->all());
        }

        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->gateway)->where('currency', $request->currency)->first();

        if (!$gate) {
            $notify[] = 'Invalid gateway';
            return jsonResponse('invalid_gateway', 'error', $notify);
        }

        $charge      = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable     = $amount + $charge;
        $finalAmount = $payable * $gate->rate;

        $data                      = new Deposit();
        $data->user_id             = $user->id;
        $data->plan_id             = $plan->id;
        $data->plan_recurring_type = $request->recurring_type;
        $data->method_code         = $gate->method_code;
        $data->method_currency     = strtoupper($gate->currency);
        $data->amount              = $amount;
        $data->charge              = $charge;
        $data->rate                = $gate->rate;
        $data->final_amount        = $finalAmount;
        $data->btc_amount          = 0;
        $data->btc_wallet          = "";
        $data->trx                 = getTrx();
        $data->success_url         = route('user.deposit.history');
        $data->failed_url          = urlPath('home');
        $data->save();

        $message[] = 'Deposit created. Continue to payment.';
        return jsonResponse('plan_purchase', 'success', $message, [
            'deposit'       => $data,
            'track'         => $data->trx,
            'redirect_url'  => route('deposit.app.confirm', encrypt($data->id)),
        ]);
    }

    private function manageFreePlanPurchase($user, $plan)
    {
        if ($user->plan_id) {
            $notify[] = 'You have already subscribed a plan, you can not subscribe again to a free plan.';
            return jsonResponse('already_subscribed', 'error', $notify);
        }

        $planPurchase                       = new PlanPurchase();
        $planPurchase->user_id              = $user->id;
        $planPurchase->amount               = 0;
        $planPurchase->subscription_plan_id = $plan->id;
        $planPurchase->recurring_type       = Status::MONTHLY;
        $planPurchase->expired_at           = Carbon::now()->addMonths(1);
        $planPurchase->save();

        $user->plan_id         = $plan->id;
        $user->plan_expired_at = Carbon::now()->addMonths(1);
        $user->product_limit   = $plan->product_limit   == Status::UNLIMITED ? Status::UNLIMITED : $user->product_limit + $plan->product_limit;
        $user->user_limit      = $plan->user_limit      == Status::UNLIMITED ? Status::UNLIMITED : $user->user_limit + $plan->user_limit;
        $user->warehouse_limit = $plan->warehouse_limit == Status::UNLIMITED ? Status::UNLIMITED : $user->warehouse_limit + $plan->warehouse_limit;
        $user->supplier_limit  = $plan->supplier_limit  == Status::UNLIMITED ? Status::UNLIMITED : $user->supplier_limit + $plan->supplier_limit;
        $user->coupon_limit    = $plan->coupon_limit    == Status::UNLIMITED ? Status::UNLIMITED : $user->coupon_limit + $plan->coupon_limit;
        $user->hrm_access      = $plan->hrm_access;
        $user->save();

        $notify[] = 'You have successfully subscribed to a free plan.';
        return jsonResponse('free_plan_subscribed', 'success', $notify, [
            'plan_purchase' => $planPurchase,
            'plan'          => $plan,
            'user'          => $user,
        ]);
    }

    public function purchasePlanHistory()
    {
        $plans = PlanPurchase::where('user_id', auth()->id())->with('subscriptionPlan')->latest()->paginate(getPaginate());
        return jsonResponse("purchased_plans", "success", ['Fetched successfully'], [
            'plans' => $plans,
            'user'  => auth()->user()
        ]);
    }
}
