
<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WhatsappOrder;
use App\Models\WhatsappStoreSetting;
use App\Models\WhatsappPublishedProduct;
use Illuminate\Http\Request;

class PublicStoreController extends Controller
{
    /**
     * صفحة المتجر العامّة - يصلها العميل عبر الرابط
     */
    public function show(string $slug)
    {
        $setting = WhatsappStoreSetting::where('store_slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = WhatsappPublishedProduct::where('company_id', $setting->company_id)
            ->where('is_published', true)
            ->where('availability', 'in_stock')
            ->with('product')
            ->orderBy('display_order')
            ->orderBy('id')
            ->get();

        return view('storefront.show', compact('setting', 'products'));
    }

    /**
     * AJAX: قائمة المنتجات (للبحث/الفلترة)
     */
    public function products(Request $request, string $slug)
    {
        $setting = WhatsappStoreSetting::where('store_slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $query = WhatsappPublishedProduct::where('company_id', $setting->company_id)
            ->where('is_published', true)
            ->with('product');

        if ($search = $request->get('search')) {
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('display_order')->get()->map(function ($pp) {
            return [
                'id' => $pp->id,
                'product_id' => $pp->product_id,
                'name' => $pp->effective_name,
                'description' => $pp->effective_description,
                'price' => $pp->effective_price,
                'image' => $pp->effective_image,
                'min_qty' => $pp->min_qty,
                'max_qty' => $pp->max_qty,
                'is_featured' => $pp->is_featured,
            ];
        });

        return response()->json(['products' => $products]);
    }

    /**
     * إنشاء طلب من المتجر العام → يفتح واتساب
     */
    public function checkout(Request $request, string $slug)
    {
        $setting = WhatsappStoreSetting::where('store_slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|min:10|max:20',
            'delivery_address' => 'nullable|string|max:500',
            'order_type' => 'in:pickup,delivery',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.qty' => 'required|integer|min:1',
            'customer_notes' => 'nullable|string|max:500',
            'payment_method' => 'nullable|in:cash,apple_pay,google_pay,mada,visa',
        ]);

        // جلب المنتجات + التحقّق من السعر
        $productIds = collect($validated['items'])->pluck('product_id');
        $publishedProducts = WhatsappPublishedProduct::where('company_id', $setting->company_id)
            ->whereIn('product_id', $productIds)
            ->where('is_published', true)
            ->with('product')
            ->get()
            ->keyBy('product_id');

        $items = [];
        $subtotal = 0;

        foreach ($validated['items'] as $reqItem) {
            $pp = $publishedProducts->get($reqItem['product_id']);
            if (!$pp) continue;

            $price = $pp->effective_price;
            $qty = $reqItem['qty'];
            $itemSubtotal = $price * $qty;
            $subtotal += $itemSubtotal;

            $items[] = [
                'product_id' => $pp->product_id,
                'name' => $pp->effective_name,
                'price' => $price,
                'qty' => $qty,
                'subtotal' => $itemSubtotal,
                'image' => $pp->effective_image,
            ];
        }

        if (empty($items)) {
            return response()->json(['error' => 'لم يتمّ إيجاد المنتجات'], 422);
        }

        // التحقّق من الحدّ الأدنى
        if ($subtotal < $setting->min_order_amount) {
            return response()->json([
                'error' => "الحدّ الأدنى للطلب: {$setting->min_order_amount} ر",
            ], 422);
        }

        // حساب الإجماليّات
        $deliveryFee = $validated['order_type'] === 'delivery' ? $setting->delivery_fee : 0;
        $taxRate = 15.00;
        $taxAmount = round(($subtotal + $deliveryFee) * ($taxRate / 100), 2);
        $total = $subtotal + $deliveryFee + $taxAmount;

        // إنشاء الطلب
        $order = WhatsappOrder::create([
            'company_id' => $setting->company_id,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => preg_replace('/\D/', '', $validated['customer_phone']),
            'order_type' => $validated['order_type'] ?? 'delivery',
            'delivery_address' => $validated['delivery_address'] ?? null,
            'customer_notes' => $validated['customer_notes'] ?? null,
            'items' => $items,
            'items_count' => count($items),
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'tax_amount' => $taxAmount,
            'tax_rate' => $taxRate,
            'total' => $total,
            'payment_method' => $validated['payment_method'] ?? 'cash',
            'payment_status' => 'pending',
            'status' => 'pending',
            'source' => 'web_storefront',
        ]);

        // توليد رابط واتساب جاهز
        $service = app(\App\Services\WhatsappService::class);
        $whatsappUrl = $service->generateOrderWhatsappLink($order, $setting);

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
            'whatsapp_url' => $whatsappUrl,
            'total' => $total,
        ]);
    }
}
