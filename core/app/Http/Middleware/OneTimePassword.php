<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;
use Illuminate\Support\Facades\Auth;

class OneTimePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->one_time_password === Status::YES) {
                if (isApiRequest()) {
                    $notify[] = 'You need to change your password.';
                    return jsonResponse("password_change_required", "error", $notify);
                } else {
                    if ($request->routeIs(['user.change.password', 'user.logout', "user.change.password", "user/logout"])) {
                        return $next($request);
                    } else {
                        return to_route('user.change.password');
                    }
                }
            }
        }

        return $next($request);
    }
}
