<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            Log::info('Google OAuth User Data', [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
            ]);

            // Check if user exists by Google ID
            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                Log::info('User logged in via Google OAuth (existing Google ID)', [
                    'email' => $user->email,
                    'user_id' => $user->id,
                    'google_id' => $googleUser->getId(),
                    'ip' => request()->ip(),
                ]);
                
                Auth::login($user);
                
                // Redirect based on role
                $redirectTo = $user->role && $user->role->slug === 'admin' 
                    ? route('dashboard') 
                    : route('home');
                
                return redirect()->intended($redirectTo);
            }

            // Check if user exists by email
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                // Auto-link Google account to existing user
                $existingUser->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);

                Log::info('User logged in via Google OAuth and account auto-linked', [
                    'email' => $existingUser->email,
                    'user_id' => $existingUser->id,
                    'google_id' => $googleUser->getId(),
                    'ip' => request()->ip(),
                ]);

                Auth::login($existingUser);
                
                // Redirect based on role
                $redirectTo = $existingUser->role && $existingUser->role->slug === 'admin' 
                    ? route('dashboard') 
                    : route('home');
                
                return redirect()->intended($redirectTo);
            }

            // Get default user role
            $defaultRole = Role::where('slug', 'user')->first();

            // Create new user with Google account
            $newUser = User::create([
                'first_name' => $googleUser->user['given_name'] ?? '',
                'last_name' => $googleUser->user['family_name'] ?? '',
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(32)), // Random password for security
                'role_id' => $defaultRole?->id ?? 2, // Default to user role
            ]);

            Log::info('New user created and logged in via Google OAuth', [
                'email' => $newUser->email,
                'user_id' => $newUser->id,
                'google_id' => $googleUser->getId(),
                'ip' => request()->ip(),
            ]);

            Auth::login($newUser);
            
            // New users always go to home page (user role)
            return redirect()->intended(route('home'));

        } catch (\Exception $e) {
            Log::error('Google OAuth authentication failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return redirect()->route('login')->withErrors([
                'email' => 'Failed to authenticate with Google. Please try again.',
            ]);
        }
    }
}
