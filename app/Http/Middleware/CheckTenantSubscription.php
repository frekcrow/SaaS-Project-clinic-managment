<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTenantSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->tenant) {
            if (!$request->user()->tenant->hasValidSubscription()) {
                return redirect()->route('tenant.license.show_activate');
            }

            // Expiration warning logic
            if ($request->user()->tenant->subscription_expires_at && $request->user()->tenant->subscription_expires_at->diffInDays(now()) < 7) {
                \Illuminate\Support\Facades\View::share('subscriptionWarning', true);
            }
        }

        return $next($request);
    }
}
