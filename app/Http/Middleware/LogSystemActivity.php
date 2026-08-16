<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;

class LogSystemActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']) && $request->user()) {
            $username = $request->user()->name;
            $method = $request->method();
            $url = $request->fullUrl();
            $ip = $request->ip();
            $date = now()->format('Y-m-d H:i:s');

            $logEntry = "[$date] User: {$username} | Action: {$method} {$url} | IP: {$ip}" . PHP_EOL;

            $logPath = storage_path('logs/blackbox.log');
            File::append($logPath, $logEntry);
        }

        return $response;
    }
}
