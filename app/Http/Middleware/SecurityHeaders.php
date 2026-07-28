<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request with security headers.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Force HTTPS redirect if not already secure
        if (!$request->secure() && app()->environment('production')) {
            return redirect()->secure($request->getRequestUri());
        }

        $response = $next($request);

        // Prevent clickjacking attacks
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Disable MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable XSS protection in older browsers
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy - control how much referrer info is shared
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy - restrict browser features
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Content Security Policy
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' data:; connect-src 'self';"
        );

        // HTTP Strict Transport Security - enforce HTTPS for 1 year
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        return $response;
    }
}

