<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only track GET requests (ignore form submissions, AJAX, etc.)
        if ($request->isMethod('GET') && ! $request->expectsJson()) {
            $ip   = $request->ip();
            $page = $request->path();

            // Throttle: record at most once per IP+page every 5 minutes
            $cacheKey = 'visitor_' . md5($ip . $page);

            if (! Cache::has($cacheKey)) {
                Cache::put($cacheKey, true, now()->addMinutes(5));

                Visitor::create([
                    'ip_address' => $ip,
                    'page'       => '/' . $page,
                    'user_agent' => substr($request->userAgent() ?? '', 0, 500),
                ]);
            }
        }

        return $next($request);
    }
}
