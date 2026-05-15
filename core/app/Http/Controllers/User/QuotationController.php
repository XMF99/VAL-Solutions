<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * ═══════════════════════════════════════════════════
     * 1. قائمة عروض الأسعار
     * ═══════════════════════════════════════════════════
     */
    public function list(Request $request)
    {
        $pageTitle = 'عروض الأسعار';
        $user      = getParentUser();

        // ─── فلترة بالحالة ───
        $query = Quotation::with('customer')
            ->forUser($user->id)
            ->latest('id');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('quotation_status', $request->status);
        }

        // ─── بحث ───
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('quotation_no', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($c) use ($search) {
                      $c->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $quotations = $query->paginate(20);

        // ─── إحصائيّات سريعة ───
        $stats = [
            'total'    => Quotation::forUser($user->id)->count(),
            'draft'    => Quotation::forUser($user->id)->draft()->count(),
            'sent'     => Quotation::forUser($user->id)->sent()->count(),
            'accepted' => Quotation::forUser($user->id)->accepted()->count(),
        ];

        return view('Template::user.quotation.list', compact(
            'pageTitle', 'quotations', 'stats'
        ));
    }

    /**
     * ═══════════════════════════════════════════════════
     * 2. صفحة إنشاء عرض سعر جديد
     * ═══════════════════════════════════════════════════
     */
    public function create()
    {
        $pageTitle = 'إنشاء عرض سعر جديد';
        $user      = getParentUser();

        $customers = Customer::where('user_id', $user->id)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $products = Product::where('user_id', $user->id)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        // ─── توليد رقم عرض السعر التالي ───
        $nextQuotationNo = Quotation::generateQuotationNo($user->id);

        return view('Template::user.quotation.add', compact(
            'pageTitle', 'customers', 'products', 'nextQuotationNo'
        ));
    }

    /**
     * ═══════════════════════════════════════════════════
     * 3. حفظ عرض سعر جديد
     * ═══════════════════════════════════════════════════
     */
    public function store(Request $request)
    {
        $user = getParentUser();

        // ─── التحقّق من البيانات ───
        $request->validate([
            'customer_id'         => 'required|exists:customers,id',
            'quotation_date'      => 'required|date',
            'valid_until'         => 'required|date|after_or_equal:quotation_date',
            'items'               => 'required|array|min:1',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity'    => 'required|numeric|min:0.01',
            'items.*.unit_price'  => 'required|numeric|min:0',
            'items.*.discount'    => 'nullable|numeric|min:0|max:100',
            'items.*.tax_rate'    => 'nullable|numeric|min:0|max:100',
            'notes'               => 'nullable|string|max:5000',
        ]);

        DB::beginTransaction();
        try {
            // ─── إنشاء عرض السعر ───
            $quotation = Quotation::create([
                'user_id'          => $user->id,
                'quotation_no'     => $request->quotation_no ?? Quotation::generateQuotationNo($user->id),
                'customer_id'      => $request->customer_id,
                'quotation_date'   => $request->quotation_date,
                'valid_until'      => $request->valid_until,
                'subtotal'         => 0,
                'tax'              => 0,
                'discount'         => 0,
                'total'            => 0,
                'quotation_status' => Quotation::STATUS_DRAFT,
                'notes'            => $request->notes,
                'status'           => 1,
            ]);

            // ─── إنشاء البنود + حساب المجاميع ───
            $subtotal     = 0;
            $totalTax     = 0;
            $totalDiscount = 0;

            foreach ($request->items as $index => $item) {
                $quotationItem = new QuotationItem([
                    'quotation_id' => $quotation->id,
                    'product_id'   => $item['product_id'] ?? null,
                    'product_name' => $item['product_name'],
                    'description'  => $item['description'] ?? null,
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $item['unit_price'],
                    'discount'     => $item['discount'] ?? 0,
                    'tax_rate'     => $item['tax_rate'] ?? 0,
                    'sort_order'   => $index,
                ]);
                $quotationItem->save();

                $subtotal      += $quotationItem->subtotal;
                $totalDiscount += $quotationItem->calculateDiscountAmount();
                $totalTax      += $quotationItem->calculateTaxAmount();
            }

            // ─── تحديث المجاميع في الـquotation ───
            $quotation->update([
                'subtotal' => $subtotal,
                'discount' => $totalDiscount,
                'tax'      => $totalTax,
                'total'    => ($subtotal - $totalDiscount) + $totalTax,
            ]);

            DB::commit();

            $notify[] = ['success', 'تمّ إنشاء عرض السعر بنجاح'];
            return redirect()->route('user.quotation.list')->withNotify($notify);

        } catch (\Exception $e) {
            DB::rollBack();
            $notify[] = ['error', 'حدث خطأ: ' . $e->getMessage()];
            return back()->withInput()->withNotify($notify);
        }
    }

    /**
     * ═══════════════════════════════════════════════════
     * 4. عرض تفاصيل عرض السعر
     * ═══════════════════════════════════════════════════
     */
    public function show($id)
    {
        $user = getParentUser();

        $quotation = Quotation::with(['customer', 'items'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $pageTitle = "عرض سعر رقم: {$quotation->quotation_no}";

        return view('Template::user.quotation.view', compact('pageTitle', 'quotation'));
    }

    /**
     * ═══════════════════════════════════════════════════
     * 5. صفحة تعديل عرض السعر
     * ═══════════════════════════════════════════════════
     */
    public function edit($id)
    {
        $user = getParentUser();

        $quotation = Quotation::with(['customer', 'items'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        // ─── لا نسمح بتعديل المقبولة أو المرفوضة ───
        if (in_array($quotation->quotation_status, [Quotation::STATUS_ACCEPTED, Quotation::STATUS_REJECTED])) {
            $notify[] = ['error', 'لا يمكن تعديل عرض سعر مقبول/مرفوض'];
            return back()->withNotify($notify);
        }

        $pageTitle = "تعديل عرض سعر: {$quotation->quotation_no}";

        $customers = Customer::where('user_id', $user->id)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $products = Product::where('user_id', $user->id)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('Template::user.quotation.add', compact(
            'pageTitle', 'quotation', 'customers', 'products'
        ));
    }

    /**
     * ═══════════════════════════════════════════════════
     * 6. تحديث عرض السعر
     * ═══════════════════════════════════════════════════
     */
    public function update(Request $request, $id)
    {
        $user = getParentUser();

        $quotation = Quotation::where('user_id', $user->id)->findOrFail($id);

        $request->validate([
            'customer_id'          => 'required|exists:customers,id',
            'quotation_date'       => 'required|date',
            'valid_until'          => 'required|date|after_or_equal:quotation_date',
            'items'                => 'required|array|min:1',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity'     => 'required|numeric|min:0.01',
            'items.*.unit_price'   => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // ─── تحديث الحقول الأساسيّة ───
            $quotation->update([
                'customer_id'    => $request->customer_id,
                'quotation_date' => $request->quotation_date,
                'valid_until'    => $request->valid_until,
                'notes'          => $request->notes,
            ]);

            // ─── حذف البنود القديمة وإضافة الجديدة ───
            $quotation->items()->delete();

            $subtotal      = 0;
            $totalTax      = 0;
            $totalDiscount = 0;

            foreach ($request->items as $index => $item) {
                $quotationItem = new QuotationItem([
                    'quotation_id' => $quotation->id,
                    'product_id'   => $item['product_id'] ?? null,
                    'product_name' => $item['product_name'],
                    'description'  => $item['description'] ?? null,
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $item['unit_price'],
                    'discount'     => $item['discount'] ?? 0,
                    'tax_rate'     => $item['tax_rate'] ?? 0,
                    'sort_order'   => $index,
                ]);
                $quotationItem->save();

                $subtotal      += $quotationItem->subtotal;
                $totalDiscount += $quotationItem->calculateDiscountAmount();
                $totalTax      += $quotationItem->calculateTaxAmount();
            }

            $quotation->update([
                'subtotal' => $subtotal,
                'discount' => $totalDiscount,
                'tax'      => $totalTax,
                'total'    => ($subtotal - $totalDiscount) + $totalTax,
            ]);

            DB::commit();

            $notify[] = ['success', 'تمّ تحديث عرض السعر'];
            return redirect()->route('user.quotation.show', $quotation->id)->withNotify($notify);

        } catch (\Exception $e) {
            DB::rollBack();
            $notify[] = ['error', 'حدث خطأ: ' . $e->getMessage()];
            return back()->withInput()->withNotify($notify);
        }
    }

    /**
     * ═══════════════════════════════════════════════════
     * 7. تغيير حالة عرض السعر
     * ═══════════════════════════════════════════════════
     */
    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2,3,4',
        ]);

        $user = getParentUser();

        $quotation = Quotation::where('user_id', $user->id)->findOrFail($id);
        $quotation->update(['quotation_status' => $request->status]);

        $notify[] = ['success', "تمّ تغيير الحالة إلى: {$quotation->status_name}"];
        return back()->withNotify($notify);
    }

    /**
     * ═══════════════════════════════════════════════════
     * 8. حذف عرض السعر
     * ═══════════════════════════════════════════════════
     */
    public function delete($id)
    {
        $user = getParentUser();

        $quotation = Quotation::where('user_id', $user->id)->findOrFail($id);

        // ─── لا نسمح بحذف المقبولة ───
        if ($quotation->quotation_status == Quotation::STATUS_ACCEPTED) {
            $notify[] = ['error', 'لا يمكن حذف عرض سعر مقبول'];
            return back()->withNotify($notify);
        }

        $quotation->items()->delete();
        $quotation->delete();

        $notify[] = ['success', 'تمّ حذف عرض السعر'];
        return redirect()->route('user.quotation.list')->withNotify($notify);
    }

    /**
     * ═══════════════════════════════════════════════════
     * 9. تكرار عرض سعر (Duplicate)
     * ═══════════════════════════════════════════════════
     */
    public function duplicate($id)
    {
        $user = getParentUser();

        $original = Quotation::with('items')
            ->where('user_id', $user->id)
            ->findOrFail($id);

        DB::beginTransaction();
        try {
            // ─── إنشاء نسخة جديدة ───
            $newQuotation = $original->replicate();
            $newQuotation->quotation_no     = Quotation::generateQuotationNo($user->id);
            $newQuotation->quotation_date   = now();
            $newQuotation->valid_until      = now()->addDays(30);
            $newQuotation->quotation_status = Quotation::STATUS_DRAFT;
            $newQuotation->save();

            // ─── نسخ البنود ───
            foreach ($original->items as $item) {
                $newItem = $item->replicate();
                $newItem->quotation_id = $newQuotation->id;
                $newItem->save();
            }

            DB::commit();

            $notify[] = ['success', 'تمّ تكرار عرض السعر بنجاح'];
            return redirect()->route('user.quotation.edit', $newQuotation->id)->withNotify($notify);

        } catch (\Exception $e) {
            DB::rollBack();
            $notify[] = ['error', 'حدث خطأ: ' . $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /**
     * ═══════════════════════════════════════════════════
     * 10. طباعة (PDF)
     * ═══════════════════════════════════════════════════
     */
    public function print($id)
    {
        $user = getParentUser();

        $quotation = Quotation::with(['customer', 'items'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $pageTitle = "طباعة عرض سعر: {$quotation->quotation_no}";

        return view('Template::user.quotation.print', compact('pageTitle', 'quotation'));
    }
}