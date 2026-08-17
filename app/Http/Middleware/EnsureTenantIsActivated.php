<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantIsActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. If not authenticated, let other middlewares handle it
        if (!auth()->check()) {
            return $next($request);
        }

        // 2. Prevent redirect loops for activation routes or logout
        if ($request->routeIs('activation.*') || $request->routeIs('logout')) {
            return $next($request);
        }

        // 3. Check tenant activation status
        if ($request->user() && $request->user()->tenant) {
            if (!$request->user()->tenant->hasValidSubscription()) {
                return redirect()->route('activation.show');
            }
        }

        return $next($request);
    }
}
