<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\TwoFactorAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected TwoFactorAuthService $twoFactorAuth;

    public function __construct(TwoFactorAuthService $twoFactorAuth)
    {
        $this->twoFactorAuth = $twoFactorAuth;
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        // 2FA is now mandatory for all users
        if ($user->hasTwoFactorEnabled()) {
            // User has 2FA enabled - redirect to verification
            session(['2fa_user_id' => $user->id]);
            Auth::guard('web')->logout();
            return redirect()->route('2fa.verify');
        } else {
            // User doesn't have 2FA enabled - force setup
            session(['2fa_user_id' => $user->id]);
            Auth::guard('web')->logout();
            return redirect()->route('2fa.setup')->with('warning', 'Two-factor authentication is required for all users. Please set it up to continue.');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $this->twoFactorAuth->clearSessionVerification();

        return redirect('/');
    }
}
