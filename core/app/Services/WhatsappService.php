
<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\WhatsappOrder;
use App\Models\WhatsappCustomer;
use App\Models\WhatsappMessage;
use App\Models\WhatsappStoreSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * WhatsApp Service - المنطق المركزي للـ Module
 * 
 * المهام الرئيسيّة:
 * - تحويل WhatsApp Order → POS Sale
 * - مطابقة العملاء (Customer Matching)
 * - إرسال رسائل عبر Meta Cloud API
 * - تتبّع الإحصائيّات
 */
class WhatsappService
{
    private const META_API_VERSION = 'v18.0';
    private const META_API_BASE = 'https://graph.facebook.com';

    /**
     * تحويل طلب الواتساب إلى فاتورة POS (Sale)
     */
    public function convertOrderToSale(WhatsappOrder $order): ?Sale
    {
        if ($order->isConvertedToSale()) {
            return $order->sale;
        }

        try {
            return DB::transaction(function () use ($order) {
                // 1. مطابقة العميل أو إنشاؤه
                $customer = $this->matchOrCreateCustomer($order);

                // 2. إنشاء Sale (الفاتورة في POS)
                $sale = Sale::create([
                    'company_id' => $order->company_id,
                    'customer_id' => $customer?->id,
                    'sale_date' => now(),
                    'subtotal' => $order->subtotal,
                    'tax_amount' => $order->tax_amount,
                    'discount_amount' => $order->discount_amount,
                    'total' => $order->total,
                    'paid_amount' => $order->payment_status === 'paid' ? $order->total : 0,
                    'due_amount' => $order->payment_status === 'paid' ? 0 : $order->total,
                    'payment_status' => $order->payment_status === 'paid' ? 'paid' : 'pending',
                    'status' => 'pending',
                    'note' => 'طلب واتساب #' . $order->order_number,
                    'reference_number' => $order->order_number,
                ]);

                // 3. إنشاء تفاصيل الفاتورة (SaleDetails)
                foreach ($order->items as $item) {
                    SaleDetails::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item['product_id'] ?? null,
                        'product_name' => $item['name'],
                        'quantity' => $item['qty'],
                        'price' => $item['price'],
                        'subtotal' => ($item['price'] * $item['qty']),
                    ]);
                }

                // 4. ربط الطلبين
                $order->update([
                    'sale_id' => $sale->id,
                    'customer_id' => $customer?->id,
                    'status' => 'confirmed',
                    'confirmed_at' => now(),
                ]);

                // 5. تحديث إحصائيّات العميل
                if ($order->whatsappCustomer) {
                    $order->whatsappCustomer->recordOrder($order);
                }

                Log::info('WhatsApp order converted to sale', [
                    'whatsapp_order_id' => $order->id,
                    'sale_id' => $sale->id,
                ]);

                return $sale;
            });
        } catch (\Throwable $e) {
            Log::error('Failed to convert WhatsApp order', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * مطابقة عميل OvoSale أو إنشاء واحد جديد
     */
    public function matchOrCreateCustomer(WhatsappOrder $order): mixed
    {
        $customerClass = '\App\Models\Customer';
        if (!class_exists($customerClass)) {
            return null;
        }

        // البحث برقم الجوّال (آخر 9 أرقام)
        $normalized = preg_replace('/\D/', '', $order->customer_phone);
        $lastNine = substr($normalized, -9);

        $customer = $customerClass::where('company_id', $order->company_id)
            ->where(function ($q) use ($lastNine) {
                $q->where('mobile', 'like', '%' . $lastNine)
                  ->orWhere('phone', 'like', '%' . $lastNine);
            })
            ->first();

        if ($customer) {
            return $customer;
        }

        // إنشاء عميل جديد
        try {
            return $customerClass::create([
                'company_id' => $order->company_id,
                'name' => $order->customer_name,
                'mobile' => $order->customer_phone,
                'email' => $order->customer_email,
                'address' => $order->delivery_address,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Could not auto-create customer', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * إرسال رسالة نصّيّة عبر Meta Cloud API
     */
    public function sendTextMessage(
        WhatsappStoreSetting $setting,
        string $toPhone,
        string $message
    ): array {
        if (!$setting->isConnected()) {
            return ['success' => false, 'error' => 'Account not connected'];
        }

        $url = self::META_API_BASE . '/' . self::META_API_VERSION 
            . '/' . $setting->whatsapp_phone_id . '/messages';

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $toPhone,
            'type' => 'text',
            'text' => ['body' => $message, 'preview_url' => true],
        ];

        try {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $setting->access_token,
                    'Content-Type: application/json',
                ],
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_TIMEOUT => 15,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $data = json_decode($response, true);

            if ($httpCode === 200 && isset($data['messages'][0]['id'])) {
                return ['success' => true, 'message_id' => $data['messages'][0]['id']];
            }

            return ['success' => false, 'error' => $data['error']['message'] ?? 'Unknown error'];
        } catch (\Throwable $e) {
            Log::error('Meta API send failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * توليد رسالة طلب جاهزة للواتساب (wa.me link)
     */
    public function generateOrderWhatsappLink(WhatsappOrder $order, WhatsappStoreSetting $setting): string
    {
        $message = "🛒 *طلب جديد - {$setting->store_name}*\n";
        $message .= "═══════════════════\n";
        $message .= "🆔 رقم الطلب: #{$order->order_number}\n";
        $message .= "👤 العميل: {$order->customer_name}\n";
        $message .= "📞 الجوّال: {$order->customer_phone}\n";
        
        if ($order->delivery_address) {
            $message .= "📍 العنوان: {$order->delivery_address}\n";
        }
        
        $message .= "═══════════════════\n";
        $message .= "📦 *المنتجات:*\n";
        
        foreach ($order->items as $item) {
            $subtotal = $item['price'] * $item['qty'];
            $message .= "• {$item['name']} × {$item['qty']} = {$subtotal} ر\n";
        }
        
        $message .= "═══════════════════\n";
        $message .= "💰 *الإجمالي: {$order->total} ر*";

        return 'https://wa.me/' . $setting->whatsapp_number 
            . '?text=' . urlencode($message);
    }

    /**
     * التحقّق من تفعيل الباقة الثالثة للتاجر
     */
    public function hasWhatsappPlan(Company $company): bool
    {
        // التحقّق من الباقة عبر علاقة PlanPurchase
        $purchase = $company->planPurchases()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->latest()
            ->first();

        if (!$purchase) {
            return false;
        }

        // الباقة الثالثة (Premium) — id = 3
        return $purchase->subscription_plan_id >= 3;
    }

    /**
     * إحصائيّات سريعة للوحة
     */
    public function getDashboardStats(int $companyId): array
    {
        $today = today();
        
        return [
            'today_orders' => WhatsappOrder::where('company_id', $companyId)
                ->whereDate('created_at', $today)->count(),
            
            'pending_orders' => WhatsappOrder::where('company_id', $companyId)
                ->where('status', 'pending')->count(),
            
            'today_revenue' => WhatsappOrder::where('company_id', $companyId)
                ->whereDate('created_at', $today)
                ->whereIn('status', ['confirmed', 'preparing', 'ready', 'completed'])
                ->sum('total'),
            
            'active_customers' => WhatsappCustomer::where('company_id', $companyId)
                ->where('last_message_at', '>=', now()->subDays(30))
                ->count(),
            
            'total_messages_today' => WhatsappMessage::where('company_id', $companyId)
                ->whereDate('created_at', $today)->count(),
        ];
    }
}
