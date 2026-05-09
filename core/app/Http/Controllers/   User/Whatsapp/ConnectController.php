
<?php

namespace App\Http\Controllers\User\Whatsapp;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * ربط حساب التاجر بـ Meta Cloud API
 * 
 * 3 طرق:
 * 1. Embedded Signup (لاحقاً - يحتاج Tech Provider approval)
 * 2. Manual Token (الآن)
 * 3. Verify Token (للاختبار)
 */
class ConnectController extends BaseController
{
    /**
     * صفحة الربط
     */
    public function show()
    {
        return view('user.whatsapp.connect', [
            'setting' => $this->setting,
            'isConnected' => $this->setting->isConnected(),
        ]);
    }

    /**
     * Embedded Signup (للمستقبل)
     */
    public function handleEmbeddedSignup(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'phone_number_id' => 'required|string',
            'waba_id' => 'required|string',
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Embedded Signup غير مفعّل بعد - استخدم الربط اليدوي',
        ], 501);
    }

    /**
     * الربط اليدوي
     */
    public function handleManualConnect(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_number' => 'required|string|min:10|max:20',
            'whatsapp_phone_id' => 'required|string|max:100',
            'whatsapp_business_id' => 'required|string|max:100',
            'access_token' => 'required|string|min:50',
            'catalog_id' => 'nullable|string|max:100',
        ]);

        // تنظيف رقم الجوّال
        $validated['whatsapp_number'] = preg_replace('/\D/', '', $validated['whatsapp_number']);

        // التحقّق من Token
        $verifyResult = $this->verifyMetaToken(
            $validated['access_token'],
            $validated['whatsapp_phone_id']
        );

        if (!$verifyResult['valid']) {
            return back()->withInput()->with('error', 
                'فشل التحقّق من Token: ' . ($verifyResult['error'] ?? 'غير صالح')
            );
        }

        // توليد Webhook Verify Token
        if (empty($this->setting->webhook_verify_token)) {
            $validated['webhook_verify_token'] = Str::random(32);
        }

        // حفظ الإعدادات
        $this->setting->update(array_merge($validated, [
            'whatsapp_display_name' => $verifyResult['display_name'] ?? null,
            'is_active' => true,
            'is_verified' => true,
            'connected_at' => now(),
        ]));

        return redirect()->route('user.whatsapp.dashboard')
            ->with('success', 'تمّ ربط حساب الواتساب بنجاح! 🎉');
    }

    /**
     * AJAX: التحقّق من Token
     */
    public function verifyToken(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
            'whatsapp_phone_id' => 'required|string',
        ]);

        $result = $this->verifyMetaToken(
            $request->access_token,
            $request->whatsapp_phone_id
        );

        return response()->json($result);
    }

    /**
     * فصل الحساب
     */
    public function disconnect(Request $request)
    {
        $this->setting->update([
            'access_token' => null,
            'whatsapp_phone_id' => null,
            'is_active' => false,
            'is_verified' => false,
            'connected_at' => null,
        ]);

        return redirect()->route('user.whatsapp.dashboard')
            ->with('success', 'تمّ فصل الحساب بنجاح');
    }

    /**
     * استدعاء Meta API للتحقّق من Token
     */
    protected function verifyMetaToken(string $token, string $phoneId): array
    {
        $url = "https://graph.facebook.com/v18.0/{$phoneId}";

        try {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token],
                CURLOPT_TIMEOUT => 10,
            ]);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $data = json_decode($response, true);

            if ($httpCode === 200 && isset($data['display_phone_number'])) {
                return [
                    'valid' => true,
                    'phone_number' => $data['display_phone_number'] ?? null,
                    'display_name' => $data['verified_name'] ?? null,
                    'quality_rating' => $data['quality_rating'] ?? null,
                ];
            }

            return [
                'valid' => false,
                'error' => $data['error']['message'] ?? 'Token غير صالح',
            ];
        } catch (\Throwable $e) {
            return ['valid' => false, 'error' => $e->getMessage()];
        }
    }
}
