<?php

namespace App\Providers;

use App\Http\Responses\LoginResponse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register custom login response for role-based redirects
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register Fortify views
        Fortify::loginView(fn () => inertia('auth/login'));
        Fortify::registerView(fn () => inertia('auth/register'));
        Fortify::requestPasswordResetLinkView(fn () => inertia('auth/forgot-password'));
        Fortify::resetPasswordView(fn ($request) => inertia('auth/reset-password', [
            'email' => $request->input('email'),
            'token' => $request->route('token'),
        ]));
        Fortify::verifyEmailView(fn () => inertia('auth/verify-email'));
        Fortify::confirmPasswordView(fn () => inertia('auth/confirm-password'));
        Fortify::twoFactorChallengeView(fn () => inertia('auth/two-factor-challenge'));

        // Configure rate limiting
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
