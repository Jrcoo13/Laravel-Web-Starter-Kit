<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['first_name', 'last_name', 'name', 'email', 'password', 'google_id', 'avatar', 'profile_photo_path', 'role_id'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

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
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    /**
     * Get the user's role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user's profile photo URL.
     * 
     * Returns a secure URL that serves the photo through a controller
     * with proper authentication checks.
     */
    protected function profilePhotoUrl(): Attribute
    {
        return Attribute::get(function () {
            // If user has uploaded a profile photo, return secure route
            if ($this->profile_photo_path) {
                return route('profile-photo.show', ['user' => $this->id]);
            }

            // If user has Google avatar, use it
            if ($this->avatar) {
                return $this->avatar;
            }

            // Fallback to UI Avatars service with initials
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
        });
    }

    /**
     * Get the user's full name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? '')),
        );
    }

    /**
     * Check if user has completed their profile.
     */
    public function hasCompletedProfile(): bool
    {
        return filled($this->first_name) && filled($this->last_name);
    }
}
