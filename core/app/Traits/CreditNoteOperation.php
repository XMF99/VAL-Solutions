<?php

namespace App\Traits;

use App\Models\CreditNote;
use App\Models\CreditNoteDetail;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * ═══════════════════════════════════════════════════════════
 * Credit Note Operations Trait
 * ═══════════════════════════════════════════════════════════
 * 
 * يحتوي على كل البزنس لوجيك لإشعارات دائنة:
 *   - إنشاء إشعار جديد
 *   - تطبيق الإشعار على الفاتورة الأصليّة
 *   - حساب الرصيد
 *   - تأثير على المخزون
 *   - إلغاء الإشعار
 * 
 * يُستخدم بـ: use CreditNoteOperation; في Controller
 * ────────────────────────────────────────────────────────────
 */
trait CreditNoteOperation
{
    /**
     * إنشاء إشعار دائن جديد
     */
    public function storeCreditNote(Request $request, $isPosSale = false)
    {
        $user = getParentUser();
        
        DB::beginTransaction();
        
        try {
            // ───── إنشاء الإشعار الرئيسي ─────
            $creditNote = new CreditNote();
            $creditNote->user_id = $user->id;
            $creditNote->credit_note_number = $this->generateCreditNoteNumber();
            $creditNote->credit_note_date = $request->credit_note_date ?? now()->format('Y-m-d');
            $creditNote->sale_id = $request->sale_id ?? 0;
            $creditNote->customer_id = $request->customer_id;
            $creditNote->warehouse_id = $request->warehouse_id ?? 0;
            $creditNote->reason = $request->reason ?? 'return';
            $creditNote->note = $request->note;
            $creditNote->issued_by = auth()->id();
            $creditNote->status = CreditNote::STATUS_ACTIVE;
            $creditNote->affects_inventory = $request->affects_inventory ?? true;

            // ───── ربط رقم الفاتورة الأصليّة لو موجود ─────
            if ($request->sale_id) {
                $sale = Sale::where('user_id', $user->id)->find($request->sale_id);
                if ($sale) {
                    $creditNote->original_invoice_number = $sale->invoice_number;
                }
            }

            // ───── حساب المبالغ من السطور ─────
            $subtotal = 0;
            $totalTax = 0;
            $totalDiscount = 0;

            if (is_array($request->products ?? null)) {
                foreach ($request->products as $product) {
                    $qty = (int) ($product['quantity'] ?? 0);
                    $price = (float) ($product['unit_price'] ?? 0);
                    $taxAmount = (float) ($product['tax_amount'] ?? 0);
                    $discountAmount = (float) ($product['discount_amount'] ?? 0);
                    
                    $lineSubtotal = ($qty * $price) - $discountAmount + $taxAmount;
                    $subtotal += $lineSubtotal;
                    $totalTax += $taxAmount;
                    $totalDiscount += $discountAmount;
                }
            }

            $creditNote->subtotal = $subtotal;
            $creditNote->discount_type = $request->discount_type ?? 0;
            $creditNote->discount_value = $request->discount_value ?? 0;
            $creditNote->discount_amount = $request->discount_amount ?? 0;
            $creditNote->shipping_amount = $request->shipping_amount ?? 0;
            $creditNote->total = $subtotal + $creditNote->shipping_amount - $creditNote->discount_amount;
            $creditNote->balance_amount = $creditNote->total;
            
            $creditNote->save();

            // ───── إضافة سطور المنتجات ─────
            if (is_array($request->products ?? null)) {
                foreach ($request->products as $product) {
                    $detail = new CreditNoteDetail();
                    $detail->credit_note_id = $creditNote->id;
                    $detail->product_id = $product['product_id'];
                    $detail->product_details_id = $product['product_details_id'] ?? 0;
                    $detail->tax_id = $product['tax_id'] ?? 0;
                    $detail->tax_type = $product['tax_type'] ?? 0;
                    $detail->tax_amount = $product['tax_amount'] ?? 0;
                    $detail->tax_percentage = $product['tax_percentage'] ?? 0;
                    $detail->discount_type = $product['discount_type'] ?? 0;
                    $detail->discount_value = $product['discount_value'] ?? 0;
                    $detail->discount_amount = $product['discount_amount'] ?? 0;
                    $detail->purchase_price = $product['purchase_price'] ?? 0;
                    $detail->unit_price = $product['unit_price'];
                    $detail->sale_price = $product['sale_price'] ?? $product['unit_price'];
                    $detail->quantity = $product['quantity'];
                    $detail->subtotal = ($product['quantity'] * $product['unit_price']) 
                                      - ($product['discount_amount'] ?? 0) 
                                      + ($product['tax_amount'] ?? 0);
                    $detail->original_sale_detail_id = $product['original_sale_detail_id'] ?? null;
                    $detail->save();

                    // ───── تحديث المخزون (إرجاع الكميّة) ─────
                    if ($creditNote->affects_inventory && $product['product_details_id']) {
                        $this->returnStockToInventory(
                            $product['product_details_id'],
                            $creditNote->warehouse_id,
                            $product['quantity']
                        );
                    }
                }
            }

            // ───── تحديث رصيد العميل ─────
            $this->updateCustomerCreditBalance($creditNote->customer_id);

            DB::commit();

            return ['success' => true, 'credit_note' => $creditNote, 'message' => 'تمّ إنشاء الإشعار الدائن بنجاح'];

        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => 'فشل إنشاء الإشعار: ' . $e->getMessage()];
        }
    }

    /**
     * تطبيق الإشعار الدائن على فاتورة (يخصم من الرصيد)
     */
    public function applyCreditNote(CreditNote $creditNote, float $amount): array
    {
        DB::beginTransaction();
        
        try {
            if ($creditNote->status != CreditNote::STATUS_ACTIVE) {
                throw new \Exception('الإشعار غير نشط');
            }

            if ($amount > $creditNote->balance_amount) {
                throw new \Exception('المبلغ المطلوب أكبر من رصيد الإشعار');
            }

            $creditNote->applied_amount += $amount;
            $creditNote->balance_amount -= $amount;

            if ($creditNote->balance_amount <= 0) {
                $creditNote->status = CreditNote::STATUS_FULLY_APPLIED;
            }

            $creditNote->save();

            $this->updateCustomerCreditBalance($creditNote->customer_id);

            DB::commit();
            return ['success' => true, 'message' => 'تمّ التطبيق بنجاح'];

        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * إلغاء إشعار دائن
     */
    public function cancelCreditNote(CreditNote $creditNote): array
    {
        DB::beginTransaction();
        
        try {
            if ($creditNote->applied_amount > 0) {
                throw new \Exception('لا يمكن إلغاء إشعار تمّ تطبيق جزء منه');
            }

            // إرجاع المخزون من حالة الإرجاع (نخصمه مرّة ثانية)
            if ($creditNote->affects_inventory) {
                foreach ($creditNote->details as $detail) {
                    if ($detail->product_details_id) {
                        $this->removeStockFromInventory(
                            $detail->product_details_id,
                            $creditNote->warehouse_id,
                            $detail->quantity
                        );
                    }
                }
            }

            $creditNote->status = CreditNote::STATUS_CANCELLED;
            $creditNote->save();

            $this->updateCustomerCreditBalance($creditNote->customer_id);

            DB::commit();
            return ['success' => true, 'message' => 'تمّ إلغاء الإشعار'];

        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * توليد رقم تسلسلي للإشعار
     */
    protected function generateCreditNoteNumber(): string
    {
        $user = getParentUser();
        $year = now()->format('Y');
        
        $lastNumber = CreditNote::where('user_id', $user->id)
            ->whereYear('created_at', $year)
            ->max('id') ?? 0;
        
        return 'CN-' . $year . '-' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
    }

    /**
     * إرجاع كميّة للمخزون
     */
    protected function returnStockToInventory(int $productDetailId, int $warehouseId, int $quantity): void
    {
        try {
            $productDetail = ProductDetail::find($productDetailId);
            if ($productDetail) {
                $productDetail->increment('stock', $quantity);
            }
        } catch (\Exception $e) {
            // log silently — لا نوقف العمليّة بسبب المخزون
        }
    }

    /**
     * خصم كميّة من المخزون (عند إلغاء الإشعار)
     */
    protected function removeStockFromInventory(int $productDetailId, int $warehouseId, int $quantity): void
    {
        try {
            $productDetail = ProductDetail::find($productDetailId);
            if ($productDetail) {
                $productDetail->decrement('stock', $quantity);
            }
        } catch (\Exception $e) {
            // log silently
        }
    }

    /**
     * تحديث رصيد إشعارات العميل الدائنة
     */
    protected function updateCustomerCreditBalance(int $customerId): void
    {
        try {
            $totalBalance = CreditNote::where('customer_id', $customerId)
                ->where('status', CreditNote::STATUS_ACTIVE)
                ->sum('balance_amount');

            // ممكن نضيف عمود credit_balance في customers لاحقاً
            // للآن، نحسبه من Query عند الحاجة
        } catch (\Exception $e) {
            // silent
        }
    }
}
