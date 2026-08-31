<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureValidTenantSubdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $host = $request->getHost();

            // Extract the subdomain (assuming host format: subdomain.domain.com)
            $parts = explode('.', $host);

            // We assume that the subdomain is the first part if there are more than 2 parts.
            // Adjust this logic if you have a different setup (e.g. localhost, local domains).
            $subdomain = null;
            if (count($parts) > 2) {
                $subdomain = $parts[0];
            } else if (count($parts) == 2 && $parts[1] == 'localhost') {
                $subdomain = $parts[0];
            } else if (count($parts) == 2 && str_ends_with($parts[1], 'test')) {
                $subdomain = $parts[0];
            }

            // Alternatively, use regex or configuration based approach to get subdomain
            // Assuming tenant->domain stores either the full domain or just the subdomain
            $tenant = Auth::user()->tenant;

            if (!$tenant) {
                abort(403, 'Unauthorized access: No tenant associated with the user.');
            }

            // If tenant->domain contains just the subdomain:
            // We will check against both exact host match and subdomain match for flexibility

            $tenantDomain = $tenant->domain;

            if ($tenantDomain) {
                 if ($tenantDomain !== $host && $tenantDomain !== $subdomain) {
                    abort(403, 'Unauthorized access to this tenant\'s subdomain.');
                 }
            }
        }

        return $next($request);
    }
}
