<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Check if user is authenticated and has 2FA enabled
        if ($user && $user->hasTwoFactorEnabled()) {
            // Check if 2FA has been verified in this session
            if (!session('2fa_verified') || session('2fa_user_id') != $user->id) {
                // Allow access to 2FA verification page
                if ($request->routeIs('2fa.verify') || $request->routeIs('2fa.verify.post')) {
                    return $next($request);
                }
                
                // Redirect to 2FA verification
                return redirect()->route('2fa.verify');
            }
        }
        
        return $next($request);
    }
}
