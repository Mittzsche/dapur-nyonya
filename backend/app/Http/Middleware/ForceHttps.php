<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Handle an incoming request.
     * Redirect HTTP ke HTTPS di production
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya aktif di production
        if (app()->environment('production')) {
            if (!$request->secure()) {
                return redirect()->secure($request->getRequestUri(), 301);
            }
        }

        return $next($request);
    }
}
