<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->tenant) {
            $tenant = $request->user()->tenant;

            // Allow access if lifetime plan
            if ($tenant->subscription_plan === 'lifetime' || $tenant->subscription_plan === null) {
                return $next($request);
            }

            if ($tenant->subscription_expires_at) {
                $expiresAt = is_string($tenant->subscription_expires_at) ? \Carbon\Carbon::parse($tenant->subscription_expires_at) : $tenant->subscription_expires_at;

                if ($expiresAt->isPast()) {
                    return redirect()->route('tenant.license.show_activate');
                }

                if ($expiresAt->diffInDays(now()) < 7) {
                    \Illuminate\Support\Facades\View::share('subscriptionWarning', true);
                }
            }
        }

        return $next($request);
    }
}
