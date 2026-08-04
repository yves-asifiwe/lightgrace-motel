<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TwoFactorAuthService
{
    public function generateOTP(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function sendOTP(User $user, string $otp): void
    {
        $timestamp = now()->format('YmdHis');
        $uniqueId = Str::random(8);

        $body = "Your verification code is: {$otp}\n\nThis code will expire in 10 minutes.\n\nIf you did not request this code, please ignore this email.";

        try {
            Mail::raw($body, function ($message) use ($user, $timestamp, $uniqueId) {
                $message->to($user->email)
                        ->subject("Verification Code #{$uniqueId} - {$timestamp}")
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
        } catch (\Throwable $e) {
            // Log and rethrow so caller can handle the failure (controllers already catch exceptions)
            \Log::error('2FA Send OTP Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function storeOTP(User $user, string $otp): void
    {
        Session::put('2fa_otp', $otp);
        Session::put('2fa_otp_user_id', $user->id);
        Session::put('2fa_otp_expires_at', Carbon::now()->addMinutes(10));
    }

    public function verifyOTP(User $user, string $code): bool
    {
        $storedOTP = Session::get('2fa_otp');
        $storedUserId = Session::get('2fa_otp_user_id');
        $expiresAt = Session::get('2fa_otp_expires_at');

        if (!$storedOTP || $storedUserId !== $user->id) {
            return false;
        }

        if (Carbon::now()->gt($expiresAt)) {
            return false;
        }

        return $storedOTP === $code;
    }

    public function enableTwoFactor(User $user): void
    {
        $user->google2fa_enabled = true;
        $user->save();
    }

    public function disableTwoFactor(User $user): void
    {
        $user->google2fa_enabled = false;
        $user->google2fa_secret = null;
        $user->google2fa_recovery_codes = null;
        $user->save();
    }

    public function generateRecoveryCodes(): array
    {
        $codes = [];
        for ($i = 0; $i < 10; $i++) {
            $codes[] = strtoupper(bin2hex(random_bytes(4)));
        }
        return $codes;
    }

    public function storeRecoveryCodes(User $user, array $codes): void
    {
        $user->google2fa_recovery_codes = encrypt(json_encode($codes));
        $user->save();
    }

    public function getRecoveryCodes(User $user): array
    {
        if (!$user->google2fa_recovery_codes) {
            return [];
        }
        return json_decode(decrypt($user->google2fa_recovery_codes), true);
    }

    public function verifyRecoveryCode(User $user, string $code): bool
    {
        $codes = $this->getRecoveryCodes($user);
        $code = strtoupper($code);

        if (in_array($code, $codes)) {
            // Remove used code
            $codes = array_diff($codes, [$code]);
            $this->storeRecoveryCodes($user, array_values($codes));
            return true;
        }

        return false;
    }

    public function setSessionVerification(User $user): void
    {
        Session::put('2fa_verified', true);
        Session::put('2fa_user_id', $user->id);
        Session::put('2fa_verified_at', now());
        Session::forget(['2fa_otp', '2fa_otp_user_id', '2fa_otp_expires_at']);
    }

    public function clearSessionVerification(): void
    {
        Session::forget(['2fa_verified', '2fa_user_id', '2fa_verified_at', '2fa_otp', '2fa_otp_user_id', '2fa_otp_expires_at']);
    }

    public function isSessionVerified(): bool
    {
        return Session::get('2fa_verified', false);
    }

    public function getCurrentSessionUserId(): ?int
    {
        return Session::get('2fa_user_id');
    }
}
