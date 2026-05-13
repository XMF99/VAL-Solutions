<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware للتحقّق من امتلاك ميزة قبل دخول الـroute
 * 
 * الاستخدام في routes:
 *   Route::middleware('has.feature:credit-note')->group(...)
 */
class HasFeature
{
    public function handle(Request $request, Closure $next, string $featureCode)
    {
        if (!userHasFeature($featureCode)) {
            // لو الطلب AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'هذه الميزة غير متاحة في باقتك الحاليّة',
                    'upgrade_required' => userCanUpgrade($featureCode),
                ], 403);
            }

            // لو طلب عادي
            $notify[] = ['error', 'هذه الميزة غير متاحة في باقتك الحاليّة. يرجى ترقية الباقة.'];
            return redirect()->route('user.subscription.plan')->withNotify($notify);
        }

        return $next($request);
    }
}
