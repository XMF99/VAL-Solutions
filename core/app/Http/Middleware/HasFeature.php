<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasFeature
{
    public function handle(Request $request, Closure $next, string $featureCode)
    {
        if (!userHasFeature($featureCode)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'هذه الميزة غير متاحة في باقتك الحاليّة',
                ], 403);
            }

            $notify[] = ['error', 'هذه الميزة غير متاحة في باقتك الحاليّة. يرجى ترقية الباقة.'];
            return back()->withNotify($notify);
        }

        return $next($request);
    }
}
