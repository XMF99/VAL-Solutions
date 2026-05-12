<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class OnboardingController extends Controller
{
    /**
     * Save business profile data and mark onboarding complete.
     * Called via AJAX (FormData / multipart) from the onboarding modal.
     */
    public function complete(Request $request)
    {
        $validated = $request->validate([
            'business_name'    => 'required|string|min:2|max:150',
            'store_name'       => 'required|string|min:2|max:150',
            'business_type'    => 'required|string|max:50',
            'business_lat'     => 'required|numeric|between:-90,90',
            'business_lng'     => 'required|numeric|between:-180,180',
            'business_address' => 'required|string|min:3|max:500',
            'cr_number'        => 'nullable|string|max:30',
            'logo'             => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ], [
            'business_name.required' => 'اسم النشاط مطلوب',
            'store_name.required'    => 'اسم المحل مطلوب',
            'business_type.required' => 'يرجى اختيار نوع النشاط',
            'business_lat.required'  => 'يرجى تحديد الموقع على الخريطة',
            'business_address.required' => 'العنوان مطلوب',
            'logo.image'             => 'يجب أن يكون الشعار صورة',
            'logo.mimes'             => 'الصور المدعومة: PNG, JPG, SVG, WebP',
            'logo.max'               => 'حجم الشعار يجب أن لا يتجاوز 2 ميجابايت',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أوّلاً',
            ], 401);
        }

        try {
            // Handle logo upload
            $logoPath = $user->logo_path; // keep existing if no new upload
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                // Delete old logo if exists
                if ($user->logo_path && Storage::disk('public')->exists($user->logo_path)) {
                    Storage::disk('public')->delete($user->logo_path);
                }
                $ext  = $request->file('logo')->getClientOriginalExtension();
                $name = 'logo_user_' . $user->id . '_' . time() . '.' . $ext;
                $logoPath = $request->file('logo')->storeAs('logos', $name, 'public');
            }

            $user->business_name    = $validated['business_name'];
            $user->store_name       = $validated['store_name'];
            $user->business_type    = $validated['business_type'];
            $user->business_lat     = $validated['business_lat'];
            $user->business_lng     = $validated['business_lng'];
            $user->business_address = $validated['business_address'];
            $user->cr_number        = $validated['cr_number'] ?? null;
            $user->logo_path        = $logoPath;
            $user->onboarding_completed    = true;
            $user->onboarding_completed_at = Carbon::now();
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'تم حفظ بيانات نشاطك بنجاح. أهلاً بك في Val POS!',
                'data' => [
                    'business_name' => $user->business_name,
                    'store_name'    => $user->store_name,
                    'business_type' => $user->business_type,
                    'logo_url'      => $logoPath ? Storage::url($logoPath) : null,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'تعذّر حفظ البيانات. يرجى المحاولة مرّة أخرى.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Skip onboarding (postpone).
     */
    public function skip(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['success' => false], 401);

        $user->onboarding_completed    = true;
        $user->onboarding_completed_at = Carbon::now();
        $user->save();

        return response()->json(['success' => true]);
    }
}
