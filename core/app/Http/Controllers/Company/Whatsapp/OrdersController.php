
<?php

namespace App\Http\Controllers\Company\Whatsapp;

use App\Models\WhatsappOrder;
use Illuminate\Http\Request;

class OrdersController extends BaseController
{
    /**
     * قائمة جميع الطلبات
     */
    public function index(Request $request)
    {
        $query = WhatsappOrder::where('company_id', $this->company->id)
            ->with(['whatsappCustomer', 'sale']);

        // فلاتر
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($from = $request->get('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->get('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        $statusCounts = [
            'all' => WhatsappOrder::where('company_id', $this->company->id)->count(),
            'pending' => WhatsappOrder::where('company_id', $this->company->id)->where('status', 'pending')->count(),
            'preparing' => WhatsappOrder::where('company_id', $this->company->id)->where('status', 'preparing')->count(),
            'ready' => WhatsappOrder::where('company_id', $this->company->id)->where('status', 'ready')->count(),
            'completed' => WhatsappOrder::where('company_id', $this->company->id)->where('status', 'completed')->count(),
        ];

        return view('company.whatsapp.orders.index', compact('orders', 'statusCounts'));
    }

    /**
     * تفاصيل طلب واحد
     */
    public function show(WhatsappOrder $order)
    {
        $this->authorize($order);

        $order->load(['whatsappCustomer', 'sale', 'messages' => function ($q) {
            $q->latest()->take(20);
        }]);

        return view('company.whatsapp.orders.show', compact('order'));
    }

    /**
     * تأكيد الطلب → تحويل لـ POS Sale
     */
    public function confirm(WhatsappOrder $order)
    {
        $this->authorize($order);

        if ($order->isConvertedToSale()) {
            return back()->with('info', 'الطلب محوّل مسبقاً لفاتورة POS');
        }

        $sale = $this->whatsappService->convertOrderToSale($order);

        if (!$sale) {
            return back()->with('error', 'فشل تحويل الطلب — حاول مرّة أخرى');
        }

        return back()->with('success', "تمّ تأكيد الطلب وإنشاء فاتورة POS #{$sale->id} ✅");
    }

    /**
     * تحديث حالة الطلب
     */
    public function updateStatus(Request $request, WhatsappOrder $order)
    {
        $this->authorize($order);

        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,out_for_delivery,delivered,completed,cancelled',
            'note' => 'nullable|string|max:500',
        ]);

        $order->updateStatus($request->status, $request->note);

        // إرسال إشعار للعميل (إذا الإعدادات تسمح)
        if ($this->setting->isConnected() && $request->boolean('notify_customer', true)) {
            $statusMessages = [
                'confirmed' => "تمّ تأكيد طلبك #{$order->order_number} ✅\nسنبدأ تجهيزه قريباً.",
                'preparing' => "🍳 طلبك #{$order->order_number} قيد التجهيز الآن.",
                'ready' => "🎉 طلبك #{$order->order_number} جاهز! يمكنك استلامه أو سيصلك قريباً.",
                'out_for_delivery' => "🚚 طلبك #{$order->order_number} في الطريق إليك.",
                'delivered' => "✅ تمّ توصيل طلبك #{$order->order_number}. نتمنّى لك تجربة ممتعة!",
                'completed' => "شكراً لطلبك! نتمنّى رؤيتك مجدّداً 🌹",
                'cancelled' => "⚠️ تمّ إلغاء طلبك #{$order->order_number}. " . ($request->note ? "السبب: {$request->note}" : ''),
            ];

            if (isset($statusMessages[$request->status])) {
                $this->whatsappService->sendTextMessage(
                    $this->setting,
                    $order->customer_phone,
                    $statusMessages[$request->status]
                );
            }
        }

        return back()->with('success', 'تمّ تحديث الحالة بنجاح');
    }

    /**
     * تحويل يدوي للـ POS (نفس confirm لكن منفصل لمرونة الأدوار)
     */
    public function convertToPOS(WhatsappOrder $order)
    {
        return $this->confirm($order);
    }

    /**
     * إلغاء الطلب
     */
    public function cancel(Request $request, WhatsappOrder $order)
    {
        $this->authorize($order);

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $order->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->reason,
            'cancelled_at' => now(),
        ]);

        // إعلام العميل
        if ($this->setting->isConnected()) {
            $this->whatsappService->sendTextMessage(
                $this->setting,
                $order->customer_phone,
                "⚠️ تمّ إلغاء طلبك #{$order->order_number}\nالسبب: {$request->reason}\nنعتذر عن الإزعاج."
            );
        }

        return back()->with('success', 'تمّ إلغاء الطلب');
    }

    /**
     * إرسال رسالة مخصّصة للعميل
     */
    public function sendMessage(Request $request, WhatsappOrder $order)
    {
        $this->authorize($order);

        $request->validate([
            'message' => 'required|string|max:1024',
        ]);

        $result = $this->whatsappService->sendTextMessage(
            $this->setting,
            $order->customer_phone,
            $request->message
        );

        if ($result['success']) {
            return back()->with('success', 'تمّ إرسال الرسالة ✅');
        }

        return back()->with('error', 'فشل الإرسال: ' . ($result['error'] ?? 'خطأ'));
    }

    /**
     * التأكّد إنّ الطلب يخصّ هذا التاجر
     */
    protected function authorize(WhatsappOrder $order): void
    {
        if ($order->company_id !== $this->company->id) {
            abort(403, 'هذا الطلب لا يخصّك');
        }
    }
}

