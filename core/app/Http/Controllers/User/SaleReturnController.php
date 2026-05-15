<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleReturnController extends Controller
{
    /**
     * ═══════════════════════════════════════════════════
     * 1. قائمة مرتجعات المبيعات
     * ═══════════════════════════════════════════════════
     */
    public function list(Request $request)
    {
        $pageTitle = 'مرتجعات المبيعات';
        $user      = getParentUser();

        // ─── فلترة ───
        $query = SaleReturn::with(['sale.customer', 'items'])
            ->forUser($user->id)
            ->latest('id');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // ─── بحث ───
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('return_no', 'like', "%{$search}%")
                  ->orWhereHas('sale', function ($s) use ($search) {
                      $s->where('invoice_no', 'like', "%{$search}%");
                  });
            });
        }

        $returns = $query->paginate(20);

        // ─── إحصائيّات ───
        $stats = [
            'total'     => SaleReturn::forUser($user->id)->count(),
            'pending'   => SaleReturn::forUser($user->id)->pending()->count(),
            'approved'  => SaleReturn::forUser($user->id)->approved()->count(),
            'completed' => SaleReturn::forUser($user->id)->completed()->count(),
        ];

        return view('Template::user.sale_return.list', compact(
            'pageTitle', 'returns', 'stats'
        ));
    }

    /**
     * ═══════════════════════════════════════════════════
     * 2. صفحة إنشاء مرتجع جديد
     * ═══════════════════════════════════════════════════
     */
    public function create()
    {
        $pageTitle = 'إنشاء مرتجع بيع';
        $user      = getParentUser();

        // جلب الفواتير التي يمكن إرجاعها
        $sales = Sale::with('customer')
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();

        return view('Template::user.sale_return.create', compact(
            'pageTitle', 'sales'
        ));
    }

    /**
     * ═══════════════════════════════════════════════════
     * 3. حفظ مرتجع جديد
     * ═══════════════════════════════════════════════════
     */
    public function store(Request $request)
    {
        $user = getParentUser();

        $request->validate([
            'sale_id'        => 'required|exists:sales,id',
            'return_date'    => 'required|date',
            'refund_method'  => 'required|in:cash,credit,exchange',
            'return_reason'  => 'nullable|string|max:5000',
            'items'          => 'required|array|min:1',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity'     => 'required|numeric|min:0.01',
            'items.*.unit_price'   => 'required|numeric|min:0',
        ]);

        // التحقّق من أن الفاتورة تابعة للمستخدم
        $sale = Sale::where('id', $request->sale_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        DB::beginTransaction();
        try {
            // ─── إنشاء المرتجع ───
            $saleReturn = SaleReturn::create([
                'user_id'       => $user->id,
                'sale_id'       => $sale->id,
                'return_no'     => $request->return_no ?? SaleReturn::generateReturnNo($user->id),
                'return_date'   => $request->return_date,
                'subtotal'      => 0,
                'tax'           => 0,
                'discount'      => 0,
                'total'         => 0,
                'refund_method' => $request->refund_method,
                'return_reason' => $request->return_reason,
                'status'        => SaleReturn::STATUS_PENDING,
            ]);

            // ─── إنشاء البنود + حساب المجاميع ───
            $subtotal      = 0;
            $totalTax      = 0;
            $totalDiscount = 0;

            foreach ($request->items as $item) {
                $returnItem = new SaleReturnItem([
                    'sale_return_id' => $saleReturn->id,
                    'sale_item_id'   => $item['sale_item_id'] ?? null,
                    'product_id'     => $item['product_id'] ?? null,
                    'product_name'   => $item['product_name'],
                    'quantity'       => $item['quantity'],
                    'unit_price'     => $item['unit_price'],
                    'discount'       => $item['discount'] ?? 0,
                    'tax_rate'       => $item['tax_rate'] ?? 0,
                    'return_reason'  => $item['return_reason'] ?? null,
                ]);
                $returnItem->save();

                $subtotal      += $returnItem->subtotal;
                $totalDiscount += $returnItem->calculateDiscountAmount();
                $totalTax      += $returnItem->calculateTaxAmount();
            }

            // ─── تحديث المجاميع ───
            $saleReturn->update([
                'subtotal' => $subtotal,
                'discount' => $totalDiscount,
                'tax'      => $totalTax,
                'total'    => ($subtotal - $totalDiscount) + $totalTax,
            ]);

            DB::commit();

            $notify[] = ['success', 'تمّ إنشاء المرتجع بنجاح'];
            return redirect()->route('user.sale_return.show', $saleReturn->id)->withNotify($notify);

        } catch (\Exception $e) {
            DB::rollBack();
            $notify[] = ['error', 'حدث خطأ: ' . $e->getMessage()];
            return back()->withInput()->withNotify($notify);
        }
    }

    /**
     * ═══════════════════════════════════════════════════
     * 4. عرض تفاصيل المرتجع
     * ═══════════════════════════════════════════════════
     */
    public function show($id)
    {
        $user = getParentUser();

        $saleReturn = SaleReturn::with(['sale.customer', 'items'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $pageTitle = "مرتجع رقم: {$saleReturn->return_no}";

        return view('Template::user.sale_return.view', compact('pageTitle', 'saleReturn'));
    }

    /**
     * ═══════════════════════════════════════════════════
     * 5. اعتماد المرتجع
     * ═══════════════════════════════════════════════════
     */
    public function approve($id)
    {
        $user = getParentUser();

        $saleReturn = SaleReturn::where('user_id', $user->id)->findOrFail($id);

        if ($saleReturn->status !== SaleReturn::STATUS_PENDING) {
            $notify[] = ['error', 'لا يمكن اعتماد مرتجع غير معلّق'];
            return back()->withNotify($notify);
        }

        $saleReturn->update(['status' => SaleReturn::STATUS_APPROVED]);

        $notify[] = ['success', 'تمّ اعتماد المرتجع'];
        return back()->withNotify($notify);
    }

    /**
     * ═══════════════════════════════════════════════════
     * 6. إكمال المرتجع (رد المبلغ + إرجاع المخزون)
     * ═══════════════════════════════════════════════════
     */
    public function complete($id)
    {
        $user = getParentUser();

        $saleReturn = SaleReturn::with('items')->where('user_id', $user->id)->findOrFail($id);

        if ($saleReturn->status !== SaleReturn::STATUS_APPROVED) {
            $notify[] = ['error', 'يجب اعتماد المرتجع أولاً'];
            return back()->withNotify($notify);
        }

        DB::beginTransaction();
        try {
            // ─── إرجاع المنتجات للمخزون (اختياري حسب النظام) ───
            foreach ($saleReturn->items as $item) {
                if ($item->product_id) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('quantity', $item->quantity);
                    }
                }
            }

            $saleReturn->update(['status' => SaleReturn::STATUS_COMPLETED]);

            DB::commit();

            $notify[] = ['success', 'تمّ إكمال المرتجع وإرجاع المنتجات للمخزون'];
            return back()->withNotify($notify);

        } catch (\Exception $e) {
            DB::rollBack();
            $notify[] = ['error', 'حدث خطأ: ' . $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /**
     * ═══════════════════════════════════════════════════
     * 7. رفض المرتجع
     * ═══════════════════════════════════════════════════
     */
    public function reject(Request $request, $id)
    {
        $user = getParentUser();

        $saleReturn = SaleReturn::where('user_id', $user->id)->findOrFail($id);

        $saleReturn->update([
            'status' => SaleReturn::STATUS_REJECTED,
            'notes'  => $request->rejection_reason,
        ]);

        $notify[] = ['success', 'تمّ رفض المرتجع'];
        return back()->withNotify($notify);
    }

    /**
     * ═══════════════════════════════════════════════════
     * 8. حذف المرتجع
     * ═══════════════════════════════════════════════════
     */
    public function delete($id)
    {
        $user = getParentUser();

        $saleReturn = SaleReturn::where('user_id', $user->id)->findOrFail($id);

        // لا نسمح بحذف مرتجع مكتمل
        if ($saleReturn->status === SaleReturn::STATUS_COMPLETED) {
            $notify[] = ['error', 'لا يمكن حذف مرتجع مكتمل'];
            return back()->withNotify($notify);
        }

        DB::transaction(function () use ($saleReturn) {
            $saleReturn->items()->delete();
            $saleReturn->delete();
        });

        $notify[] = ['success', 'تمّ حذف المرتجع'];
        return redirect()->route('user.sale_return.list')->withNotify($notify);
    }
}