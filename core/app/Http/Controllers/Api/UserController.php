<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\Form;
use App\Models\GeneralSetting;
use App\Models\Purchase;
use App\Models\Sale;
use App\Traits\AdminOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use AdminOperation;

    public function dashboard()
    {
        $user = auth()->user();
        extract(saleAndPurchaseDataForGraph(5,  "D"));
        $message[] = "user_dashboard";

        $data      = [
            'graph' => [
                'dates'    => $dates,
                'sales'    => $sales,
                'purchase' => $purchase,
            ],
            'user' => $user
        ];
        return jsonResponse(
            'sale_and_purchase_chart',
            'success',
            $message,
            $data
        );
    }

    public function kycForm()
    {
        if (auth()->user()->kv == Status::KYC_PENDING) {
            $notify[] = 'Your KYC is under review';
            return jsonResponse("under_review", "error", $notify);
        }
        if (auth()->user()->kv == Status::KYC_VERIFIED) {
            $notify[] = 'You are already KYC verified';
            return jsonResponse("already_verified", "error", $notify);
        }

        $form     = Form::where('act', 'kyc')->first();
        $notify[] = 'KYC field is below';
        return jsonResponse("kyc_form", "success", $notify, [
            'form' => $form->form_data
        ]);
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act', 'kyc')->first();
        if (!$form) {
            $notify[] = 'Invalid KYC request';
            return jsonResponse("invalid_request", "error", $notify);
        }

        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);

        $validator = Validator::make($request->all(), $validationRule);

        if ($validator->fails()) {
            return jsonResponse("validation_error", "error", $validator->errors()->all());
        }
        $user = auth()->user();
        foreach (@$user->kyc_data ?? [] as $kycData) {
            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
            }
        }
        $userData = $formProcessor->processFormData($request, $formData);

        $user->kyc_data             = $userData;
        $user->kyc_rejection_reason = null;
        $user->kv                   = Status::KYC_PENDING;
        $user->save();

        $notify[] = 'KYC data submitted successfully';
        return jsonResponse("kyc_submitted", "success", $notify);
    }

    public function salesData(Request $request)
    {
        $request->validate([
            'filter_type' => 'required|in:today,yesterday,last_7_days,last_30_days',
        ]);

        $user     = getParentUser();
        $saleQuery = Sale::where('user_id', $user->id);

        switch ($request->filter_type) {
            case 'yesterday':
                $saleQuery->whereDate('created_at', today()->subDay());
                break;
            case 'last_7_days':
                $saleQuery->whereDate('created_at', '>=', today()->subDays(7));
                break;
            case 'last_30_days':
                $saleQuery->whereDate('created_at', '>=', today()->subDays(30));
                break;
            default:
                $saleQuery->whereDate('created_at', today());
        }

        $message[] = "Sale data";

        return jsonResponse("dashboard", 'success', $message, [
            'total_sale_amount' => (clone $saleQuery)->sum('total'),
            'total_sale_count'  => $saleQuery->count()
        ]);
    }

    public function recentTransactions(Request $request)
    {
        $request->validate([
            'trx_type' => 'required|in:sale,purchase',
        ]);

        $user = getParentUser();

        if ($request->trx_type ==  'purchase') {
            $data    = Purchase::where('user_id', $user->id)->latest('id')->take(10)->get();
        } else {
            $data    = Sale::where('user_id', $user->id)->latest('id')->take(10)->get();
        }

        $message[] = "Recent Transactions";
        return jsonResponse("recent_trx", 'success', $message, [
            'data' => $data
        ]);
    }

    public function depositHistory(Request $request)
    {
        $user     = getParentUser();
        $deposits = $user->deposits()
            ->searchable(['trx'])
            ->with(['gateway'])
            ->orderBy('id', getOrderBy())
            ->paginate(getPaginate());

        $message[] = "Deposit history";
        return jsonResponse("deposit_history", 'success', $message, [
            'deposits' => $deposits
        ]);
    }

    public function prefixSettingUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_code_prefix'           => 'required',
            'purchase_invoice_prefix'       => 'required',
            'sale_invoice_prefix'           => 'required',
            'stock_transfer_invoice_prefix' => 'required',
        ]);

        if ($validator->fails()) {
            return jsonResponse('validation_error', 'error', $validator->errors()->all());
        }

        $prefixSetting = [
            'purchase_invoice_prefix'       => $request->purchase_invoice_prefix,
            'sale_invoice_prefix'           => $request->sale_invoice_prefix,
            'product_code_prefix'           => $request->product_code_prefix,
            'stock_transfer_invoice_prefix' => $request->stock_transfer_invoice_prefix,
        ];

        $general                 = gs();
        $general->prefix_setting = $prefixSetting;
        $general->save();

        adminActivity("prefix-setting-updated", get_class($general), $general->id);

        $notify[] = 'Prefix setting updated successfully';
        return jsonResponse('success', 'success', $notify);
    }
    public function userSetting()
    {

        $user      = getParentUser();
        $cacheName = 'GeneralSetting_' . $user->id;

        if (cache()->has($cacheName)) {
            $generalSetting = cache()->get($cacheName);
        } else {
            $generalSetting = GeneralSetting::where('user_id', $user->id)->first();
            if ($generalSetting) {
                cache()->put($cacheName, $generalSetting);
            } else {
                $generalSetting = gs();
            }
        }

        $notify[] = 'General setting data';
        return jsonResponse("general_setting", "success", $notify, [
            'general_setting' => $generalSetting,
        ]);
    }

    public function companySettingUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_information'         => 'required|array',
            'company_information.name'    => 'required',
            'company_information.phone'   => 'required',
            'company_information.address' => 'required',
            'company_information.email'   => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return jsonResponse('validation_error', 'error', $validator->errors()->all());
        }

        $gs = gs();
        $gs->company_information = $request->company_information;
        $gs->save();

        adminActivity("company-information-updated", get_class($gs), $gs->id);

        $notify[] = 'Company information updated successfully';
        return jsonResponse('success', 'success', $notify);
    }
}
