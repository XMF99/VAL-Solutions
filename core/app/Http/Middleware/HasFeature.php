<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

<<<<<<< HEAD
/**
 * Middleware للتحقّق من امتلاك ميزة قبل دخول الـroute
 * 
 * الاستخدام في routes:
 *   Route::middleware('has.feature:credit-note')->group(...)
 */
=======
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
class HasFeature
{
    public function handle(Request $request, Closure $next, string $featureCode)
    {
        if (!userHasFeature($featureCode)) {
<<<<<<< HEAD
            // لو الطلب AJAX
=======
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'هذه الميزة غير متاحة في باقتك الحاليّة',
<<<<<<< HEAD
                    'upgrade_required' => userCanUpgrade($featureCode),
                ], 403);
            }

            // لو طلب عادي
            $notify[] = ['error', 'هذه الميزة غير متاحة في باقتك الحاليّة. يرجى ترقية الباقة.'];
            return redirect()->route('user.subscription.plan')->withNotify($notify);
=======
                ], 403);
            }

            $notify[] = ['error', 'هذه الميزة غير متاحة في باقتك الحاليّة. يرجى ترقية الباقة.'];
            return back()->withNotify($notify);
>>>>>>> 5421e9124867a7797571dc26b266ddf4ed297deb
        }

        return $next($request);
    }
}
