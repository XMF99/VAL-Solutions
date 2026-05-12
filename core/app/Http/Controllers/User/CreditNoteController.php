<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CreditNote;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Warehouse;
use App\Traits\CreditNoteOperation;
use Illuminate\Http\Request;

class CreditNoteController extends Controller
{
    use CreditNoteOperation;

    /**
     * عرض قائمة الإشعارات الدائنة
     */
    public function list()
    {
        $user = getParentUser();
        $pageTitle = 'إشعارات دائنة';

        $creditNotes = CreditNote::where('user_id', $user->id)
            ->with(['customer', 'sale', 'issuedBy'])
            ->latest('id')
            ->paginate(20);

        return view('Template::user.credit_note.list', compact('pageTitle', 'creditNotes'));
    }

    /**
     * صفحة إنشاء إشعار جديد
     */
    public function create(Request $request)
    {
        $user = getParentUser();
        $pageTitle = 'إنشاء إشعار دائن';

        $customers = Customer::where('user_id', $user->id)->where('status', 1)->get();
        $warehouses = Warehouse::where('user_id', $user->id)->get();

        // لو فيه sale_id في الـURL، نحمّل بياناتها
        $sale = null;
        if ($request->sale_id) {
            $sale = Sale::where('user_id', $user->id)
                ->with(['saleDetails', 'customer'])
                ->find($request->sale_id);
        }

        return view('Template::user.credit_note.create', compact('pageTitle', 'customers', 'warehouses', 'sale'));
    }

    /**
     * حفظ إشعار جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'credit_note_date' => 'required|date',
            'products'       => 'required|array|min:1',
            'reason'         => 'nullable|string',
        ]);

        $result = $this->storeCreditNote($request);

        if ($result['success']) {
            $notify[] = ['success', $result['message']];
            return redirect()->route('user.credit-note.show', $result['credit_note']->id)
                ->withNotify($notify);
        }

        $notify[] = ['error', $result['message']];
        return back()->withNotify($notify)->withInput();
    }

    /**
     * عرض تفاصيل إشعار
     */
    public function show($id)
    {
        $user = getParentUser();
        $pageTitle = 'تفاصيل إشعار دائن';

        $creditNote = CreditNote::where('user_id', $user->id)
            ->with(['customer', 'sale', 'warehouse', 'issuedBy', 'details.product', 'details.productDetail'])
            ->findOrFail($id);

        return view('Template::user.credit_note.show', compact('pageTitle', 'creditNote'));
    }

    /**
     * إلغاء إشعار
     */
    public function cancel($id)
    {
        $user = getParentUser();

        $creditNote = CreditNote::where('user_id', $user->id)->findOrFail($id);

        $result = $this->cancelCreditNote($creditNote);

        $notify[] = [$result['success'] ? 'success' : 'error', $result['message']];
        return back()->withNotify($notify);
    }

    /**
     * تطبيق على فاتورة (يخصم من الرصيد)
     */
    public function apply(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $user = getParentUser();
        $creditNote = CreditNote::where('user_id', $user->id)->findOrFail($id);

        $result = $this->applyCreditNote($creditNote, $request->amount);

        $notify[] = [$result['success'] ? 'success' : 'error', $result['message']];
        return back()->withNotify($notify);
    }
}
