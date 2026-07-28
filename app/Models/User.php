<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google2fa_secret',
        'google2fa_enabled',
        'google2fa_recovery_codes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'google2fa_enabled' => 'boolean',
        ];
    }

    public function hasTwoFactorEnabled(): bool
    {
        return $this->google2fa_enabled && !empty($this->google2fa_secret);
    }

    public function setTwoFactorSecret(string $secret): void
    {
        $this->google2fa_secret = encrypt($secret);
        $this->google2fa_enabled = true;
        $this->save();
    }

    public function getTwoFactorSecret(): ?string
    {
        return $this->google2fa_secret ? decrypt($this->google2fa_secret) : null;
    }

    public function disableTwoFactor(): void
    {
        $this->google2fa_secret = null;
        $this->google2fa_enabled = false;
        $this->google2fa_recovery_codes = null;
        $this->save();
    }
}
