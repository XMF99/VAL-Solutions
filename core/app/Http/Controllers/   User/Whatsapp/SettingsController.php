
<?php

namespace App\Http\Controllers\User\Whatsapp;

use Illuminate\Http\Request;

class SettingsController extends BaseController
{
    /**
     * صفحة الإعدادات
     */
    public function edit()
    {
        return view('user.whatsapp.settings', [
            'setting' => $this->setting,
        ]);
    }

    /**
     * حفظ الإعدادات
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string|max:1000',
            'store_slug' => 'required|string|max:100|alpha_dash|unique:whatsapp_store_settings,store_slug,' . $this->setting->id,
            'theme_color' => 'nullable|string|max:20',
            'welcome_message' => 'nullable|string|max:1024',
            'away_message' => 'nullable|string|max:1024',
            'order_confirmation_message' => 'nullable|string|max:1024',
            'business_hours' => 'nullable|array',
            'min_order_amount' => 'nullable|numeric|min:0',
            'delivery_fee' => 'nullable|numeric|min:0',
            'is_open_now' => 'boolean',
            'accepts_cash' => 'boolean',
            'accepts_apple_pay' => 'boolean',
            'accepts_google_pay' => 'boolean',
            'accepts_mada' => 'boolean',
            'accepts_visa' => 'boolean',
            'accepts_bank_transfer' => 'boolean',
            'logo_url' => 'nullable|url|max:500',
            'cover_url' => 'nullable|url|max:500',
        ]);

        $this->setting->update($validated);

        return back()->with('success', 'تمّ حفظ الإعدادات بنجاح ✅');
    }

    /**
     * إرسال رسالة اختبار
     */
    public function sendTestMessage(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10',
            'message' => 'nullable|string|max:500',
        ]);

        if (!$this->setting->isConnected()) {
            return response()->json([
                'success' => false,
                'message' => 'يرجى ربط حسابك في الواتساب أوّلاً',
            ], 422);
        }

        $message = $request->message ?? 'مرحباً! هذه رسالة اختبار من ' . $this->setting->store_name . ' عبر OvoSale 🚀';

        $result = $this->whatsappService->sendTextMessage(
            $this->setting,
            $request->phone,
            $message
        );

        return response()->json([
            'success' => $result['success'],
            'message' => $result['success'] 
                ? 'تمّ إرسال الرسالة بنجاح! ✅'
                : 'فشل الإرسال: ' . ($result['error'] ?? 'خطأ غير معروف'),
        ]);
    }
}
