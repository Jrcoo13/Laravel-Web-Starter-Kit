<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $limiter  The rate limiter name (login, register, api)
     */
    public function handle(Request $request, Closure $next, string $limiter = 'api'): Response
    {
        // Bypass rate limiting for admin and agent (non-customer staff) users
        $user = $request->user('sanctum') ?? $request->user();
        if ($user && $user->role && $user->role->slug !== 'customer') {
            return $next($request);
        }

        $key = $this->resolveRequestSignature($request, $limiter);

        $maxAttempts = $this->getMaxAttempts($limiter);
        $decaySeconds = $this->getDecaySeconds($limiter);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.',
                'retry_after' => $seconds,
            ], 429)->withHeaders([
                'Retry-After' => $seconds,
                'X-RateLimit-Limit' => $maxAttempts,
                'X-RateLimit-Remaining' => 0,
            ]);
        }

        RateLimiter::hit($key, $decaySeconds);

        $response = $next($request);

        $remaining = max(0, $maxAttempts - RateLimiter::attempts($key));

        $response->headers->set('X-RateLimit-Limit', $maxAttempts);
        $response->headers->set('X-RateLimit-Remaining', $remaining);
        $response->headers->set('X-RateLimit-Reset', now()->addSeconds($decaySeconds)->timestamp);

        return $response;
    }

    /**
     * Resolve request signature for rate limiting.
     */
    protected function resolveRequestSignature(Request $request, string $limiter): string
    {
        // Use authenticated user ID if available, otherwise use IP address
        $identifier = $request->user('sanctum')?->id ?? $request->ip();

        // Include endpoint in key to allow different limits per endpoint
        return sha1($limiter . '|' . $identifier . '|' . $request->path());
    }

    /**
     * Get the maximum number of attempts for the given limiter.
     */
    protected function getMaxAttempts(string $limiter): int
    {
        return match($limiter) {
            'login' => 5,        // 5 login attempts per minute
            'register' => 3,      // 3 registrations per hour
            'appeal' => 10,       // 10 public appeal requests per minute
            'public_request' => 5, // 5 public requests per minute
            'public_lookup' => 60, // public read-only catalogs (e.g. departments list)
            'api' => 60,          // 60 API requests per minute
            default => 60,
        };
    }

    /**
     * Get the decay seconds for the given limiter.
     */
    protected function getDecaySeconds(string $limiter): int
    {
        return match($limiter) {
            'login' => 60,        // 1 minute
            'register' => 60,    // 1 minute
            'appeal' => 60,       // 1 minute
            'public_request' => 60, // 1 minute
            'public_lookup' => 60,
            'api' => 60,          // 1 minute
            default => 60,
        };
    }
}