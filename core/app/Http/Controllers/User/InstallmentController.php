<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\InstallmentPlan;
use App\Models\InstallmentPayment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InstallmentController extends Controller
{
    /**
     * ═══════════════════════════════════════════════════
     * 1. قائمة خطط التقسيط
     * ═══════════════════════════════════════════════════
     */
    public function list(Request $request)
    {
        $pageTitle = 'خطط التقسيط';
        $user      = getParentUser();

        // ─── فلترة ───
        $query = InstallmentPlan::with(['sale', 'payments'])
            ->forUser($user->id)
            ->latest('id');

        if ($request->filled('status')) {
            if ($request->status === 'completed') {
                $query->whereHas('payments', function ($q) {
                    $q->where('status', 'paid');
                }, '=', DB::raw('number_of_installments'));
            } elseif ($request->status === 'active') {
                $query->where('status', 1)
                      ->whereHas('payments', function ($q) {
                          $q->where('status', '!=', 'paid');
                      });
            }
        }

        // ─── بحث ───
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('sale', function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%");
            });
        }

        $plans = $query->paginate(20);

        // ─── إحصائيّات ───
        $stats = [
            'total'     => InstallmentPlan::forUser($user->id)->count(),
            'active'    => InstallmentPlan::forUser($user->id)->active()->count(),
            'overdue'   => InstallmentPayment::whereHas('installmentPlan', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('status', 'pending')
              ->where('due_date', '<', now())
              ->count(),
        ];

        return view('Template::user.installment.list', compact(
            'pageTitle', 'plans', 'stats'
        ));
    }

    /**
     * ═══════════════════════════════════════════════════
     * 2. صفحة إنشاء خطة تقسيط
     * ═══════════════════════════════════════════════════
     */
    public function create()
    {
        $pageTitle = 'إنشاء خطة تقسيط جديدة';
        $user      = getParentUser();

        // جلب الفواتير التي لم يتم تقسيطها بعد
        $sales = Sale::where('user_id', $user->id)
            ->where('status', 1)
            ->whereDoesntHave('installmentPlan')
            ->orderBy('id', 'desc')
            ->get();

        return view('Template::user.installment.create', compact(
            'pageTitle', 'sales'
        ));
    }

    /**
     * ═══════════════════════════════════════════════════
     * 3. حفظ خطة تقسيط جديدة
     * ═══════════════════════════════════════════════════
     */
    public function store(Request $request)
    {
        $user = getParentUser();

        $request->validate([
            'sale_id'                => 'required|exists:sales,id',
            'number_of_installments' => 'required|integer|min:2|max:36',
            'start_date'             => 'required|date',
            'frequency'              => 'required|in:daily,weekly,monthly,yearly',
            'notes'                  => 'nullable|string|max:5000',
        ]);

        // التحقّق من أن الفاتورة لم يتم تقسيطها من قبل
        $sale = Sale::where('id', $request->sale_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($sale->installmentPlan) {
            $notify[] = ['error', 'هذه الفاتورة تم تقسيطها من قبل'];
            return back()->withNotify($notify);
        }

        DB::beginTransaction();
        try {
            // ─── حساب مبلغ القسط الواحد ───
            $installmentAmount = $sale->total / $request->number_of_installments;

            // ─── إنشاء خطة التقسيط ───
            $plan = InstallmentPlan::create([
                'user_id'                => $user->id,
                'sale_id'                => $sale->id,
                'total_amount'           => $sale->total,
                'number_of_installments' => $request->number_of_installments,
                'installment_amount'     => $installmentAmount,
                'start_date'             => $request->start_date,
                'frequency'              => $request->frequency,
                'notes'                  => $request->notes,
                'status'                 => 1,
            ]);

            // ─── توليد الدفعات تلقائياً ───
            $this->generatePayments($plan);

            DB::commit();

            $notify[] = ['success', 'تمّ إنشاء خطة التقسيط وتوليد الدفعات بنجاح'];
            return redirect()->route('user.installment.show', $plan->id)->withNotify($notify);

        } catch (\Exception $e) {
            DB::rollBack();
            $notify[] = ['error', 'حدث خطأ: ' . $e->getMessage()];
            return back()->withInput()->withNotify($notify);
        }
    }

    /**
     * ═══════════════════════════════════════════════════
     * 4. عرض تفاصيل خطة التقسيط
     * ═══════════════════════════════════════════════════
     */
    public function show($id)
    {
        $user = getParentUser();

        $plan = InstallmentPlan::with(['sale.customer', 'payments' => function ($q) {
            $q->orderBy('payment_number');
        }])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $pageTitle = "خطة تقسيط فاتورة: {$plan->sale->invoice_no}";

        return view('Template::user.installment.view', compact('pageTitle', 'plan'));
    }

    /**
     * ═══════════════════════════════════════════════════
     * 5. تسجيل دفعة كمدفوعة
     * ═══════════════════════════════════════════════════
     */
    public function markAsPaid(Request $request, $paymentId)
    {
        $request->validate([
            'payment_method' => 'required|string|max:255',
            'paid_date'      => 'nullable|date',
        ]);

        $user = getParentUser();

        $payment = InstallmentPayment::whereHas('installmentPlan', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->findOrFail($paymentId);

        if ($payment->status === InstallmentPayment::STATUS_PAID) {
            $notify[] = ['error', 'هذه الدفعة مدفوعة بالفعل'];
            return back()->withNotify($notify);
        }

        $payment->markAsPaid(
            $request->payment_method,
            $request->paid_date ?? now()
        );

        $notify[] = ['success', "تمّ تسجيل القسط رقم {$payment->payment_number} كمدفوع"];
        return back()->withNotify($notify);
    }

    /**
     * ═══════════════════════════════════════════════════
     * 6. إلغاء دفعة
     * ═══════════════════════════════════════════════════
     */
    public function cancelPayment(Request $request, $paymentId)
    {
        $user = getParentUser();

        $payment = InstallmentPayment::whereHas('installmentPlan', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->findOrFail($paymentId);

        $payment->cancel($request->notes);

        $notify[] = ['success', "تمّ إلغاء القسط رقم {$payment->payment_number}"];
        return back()->withNotify($notify);
    }

    /**
     * ═══════════════════════════════════════════════════
     * 7. حذف خطة تقسيط
     * ═══════════════════════════════════════════════════
     */
    public function delete($id)
    {
        $user = getParentUser();

        $plan = InstallmentPlan::where('user_id', $user->id)->findOrFail($id);

        // التحقّق: لا نسمح بحذف خطة فيها دفعات مدفوعة
        if ($plan->paid_payments_count > 0) {
            $notify[] = ['error', 'لا يمكن حذف خطة تقسيط تحتوي على دفعات مدفوعة'];
            return back()->withNotify($notify);
        }

        DB::transaction(function () use ($plan) {
            $plan->payments()->delete();
            $plan->delete();
        });

        $notify[] = ['success', 'تمّ حذف خطة التقسيط'];
        return redirect()->route('user.installment.list')->withNotify($notify);
    }

    /**
     * ═══════════════════════════════════════════════════
     * 8. Helper: توليد الدفعات تلقائياً
     * ═══════════════════════════════════════════════════
     */
    private function generatePayments(InstallmentPlan $plan)
    {
        $startDate = Carbon::parse($plan->start_date);
        $amount    = $plan->installment_amount;

        for ($i = 1; $i <= $plan->number_of_installments; $i++) {
            // حساب تاريخ الاستحقاق
            $dueDate = match ($plan->frequency) {
                'daily'   => $startDate->copy()->addDays($i - 1),
                'weekly'  => $startDate->copy()->addWeeks($i - 1),
                'monthly' => $startDate->copy()->addMonths($i - 1),
                'yearly'  => $startDate->copy()->addYears($i - 1),
                default   => $startDate->copy()->addMonths($i - 1),
            };

            // تعديل آخر قسط ليساوي المتبقي بالضبط (تجنّب أخطاء التقريب)
            if ($i === $plan->number_of_installments) {
                $totalPaid = ($i - 1) * $amount;
                $amount    = $plan->total_amount - $totalPaid;
            }

            InstallmentPayment::create([
                'installment_plan_id' => $plan->id,
                'payment_number'      => $i,
                'amount'              => $amount,
                'due_date'            => $dueDate,
                'status'              => InstallmentPayment::STATUS_PENDING,
            ]);
        }
    }
}