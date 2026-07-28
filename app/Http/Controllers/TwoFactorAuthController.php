<?php

namespace App\Http\Controllers;

use App\Services\TwoFactorAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthController extends Controller
{
    protected TwoFactorAuthService $twoFactorAuth;

    public function __construct(TwoFactorAuthService $twoFactorAuth)
    {
        $this->twoFactorAuth = $twoFactorAuth;
    }

    public function showVerificationForm()
    {
        $userId = session('2fa_user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $user = \App\Models\User::find($userId);
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        // Generate and send OTP
        $otp = $this->twoFactorAuth->generateOTP();
        $this->twoFactorAuth->sendOTP($user, $otp);
        $this->twoFactorAuth->storeOTP($user, $otp);

        return view('auth.2fa-verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|digits:6',
        ]);

        $userId = session('2fa_user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        // Check if using recovery code
        if (strlen($request->code) === 8) {
            if ($this->twoFactorAuth->verifyRecoveryCode($user, $request->code)) {
                Auth::login($user);
                $this->twoFactorAuth->setSessionVerification($user);
                session()->forget('2fa_user_id');
                return $this->redirectToDashboard($user);
            }

            return back()->with('error', 'Invalid recovery code.');
        }

        // Verify OTP code
        if ($this->twoFactorAuth->verifyOTP($user, $request->code)) {
            Auth::login($user);
            $this->twoFactorAuth->setSessionVerification($user);
            session()->forget('2fa_user_id');
            return $this->redirectToDashboard($user);
        }

        return back()->with('error', 'Invalid code. Please try again.');
    }

    protected function redirectToDashboard($user)
    {
        switch($user->role) {
            case 'manager':
                return redirect()->intended(route('manager.dashboard', absolute: false));
            case 'recipient':
                return redirect()->intended(route('recipient.dashboard', absolute: false));
            case 'admin':
            default:
                return redirect()->intended(route('admin.dashboard', absolute: false));
        }
    }

    public function showSetupForm()
    {
        // Check if user is authenticated or has setup session (forced setup)
        $userId = session('2fa_user_id');
        $user = Auth::user();

        if (!$user && $userId) {
            // Forced setup scenario - get user from session
            $user = \App\Models\User::find($userId);
            if (!$user) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            }
        } elseif (!$user) {
            // No user found, redirect to login
            return redirect()->route('login')->with('error', 'Please login first to setup 2FA.');
        }

        if ($user->hasTwoFactorEnabled()) {
            // If already enabled and authenticated, redirect to manage
            if (Auth::check()) {
                return redirect()->route('2fa.manage')->with('info', '2FA is already enabled.');
            }
            // If already enabled but not authenticated (forced setup), verify instead
            return redirect()->route('2fa.verify');
        }

        // Generate and send test OTP for setup verification
        $otp = $this->twoFactorAuth->generateOTP();
        $this->twoFactorAuth->sendOTP($user, $otp);
        $this->twoFactorAuth->storeOTP($user, $otp);

        return view('auth.2fa-setup');
    }

    public function setup(Request $request)
    {
        $request->validate([
            'code' => 'required|string|digits:6',
        ]);

        // Get user from auth or session (forced setup)
        $userId = session('2fa_user_id');
        $user = Auth::user();

        if (!$user && $userId) {
            $user = \App\Models\User::find($userId);
            if (!$user) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            }
        } elseif (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Verify the OTP code before enabling
        if ($this->twoFactorAuth->verifyOTP($user, $request->code)) {
            $this->twoFactorAuth->enableTwoFactor($user);

            // Generate and store recovery codes
            $recoveryCodes = $this->twoFactorAuth->generateRecoveryCodes();
            $this->twoFactorAuth->storeRecoveryCodes($user, $recoveryCodes);

            // Login the user and set session verification
            Auth::login($user);
            $this->twoFactorAuth->setSessionVerification($user);
            session()->forget('2fa_user_id');

            return redirect()->route('2fa.manage')->with([
                'success' => '2FA enabled successfully!',
                'recovery_codes' => $recoveryCodes
            ]);
        }

        return back()->with('error', 'Invalid code. Please check your email and try again.');
    }

    public function showManageForm()
    {
        $user = Auth::user();
        $recoveryCodes = $user->hasTwoFactorEnabled() ? $this->twoFactorAuth->getRecoveryCodes($user) : [];
        
        return view('auth.2fa-manage', compact('user', 'recoveryCodes'));
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Incorrect password.');
        }

        $this->twoFactorAuth->disableTwoFactor($user);
        $this->twoFactorAuth->clearSessionVerification();

        return redirect()->route('2fa.manage')->with('success', '2FA has been disabled.');
    }

    public function regenerateRecoveryCodes(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Incorrect password.');
        }

        $recoveryCodes = $this->twoFactorAuth->generateRecoveryCodes();
        $this->twoFactorAuth->storeRecoveryCodes($user, $recoveryCodes);

        return redirect()->route('2fa.manage')->with([
            'success' => 'Recovery codes regenerated successfully!',
            'recovery_codes' => $recoveryCodes
        ]);
    }
}
