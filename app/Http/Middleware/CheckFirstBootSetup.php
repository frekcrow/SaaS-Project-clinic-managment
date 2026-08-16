<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFirstBootSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Bypass the middleware if running in a testing environment
        if (app()->runningUnitTests() || app()->environment('testing')) {
            return $next($request);
        }

        // Exclude the setup wizard route itself to prevent loops
        if ($request->routeIs('setup.wizard') || $request->routeIs('setup.store')) {
            return $next($request);
        }

        $flagPath = storage_path('app/first_boot.json');

        if (!file_exists($flagPath)) {
            return redirect()->route('setup.wizard');
        }

        $data = json_decode(file_get_contents($flagPath), true);
        if (empty($data['setup_complete'])) {
            return redirect()->route('setup.wizard');
        }

        return $next($request);
    }
}
