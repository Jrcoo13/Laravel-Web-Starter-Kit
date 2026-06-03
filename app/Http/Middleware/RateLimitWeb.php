<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitWeb
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     * @param  string  $limiter  The rate limiter name (web, auth, profile)
     */
    public function handle(Request $request, Closure $next, string $limiter = 'web'): Response
    {
        $key = $this->resolveRequestSignature($request, $limiter);

        $maxAttempts = $this->getMaxAttempts($limiter);
        $decaySeconds = $this->getDecaySeconds($limiter);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            return redirect()->back()->with('error', 'Too many requests. Please try again later.')->withHeaders([
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
        $identifier = $request->user()?->id ?? $request->ip();

        // Include endpoint in key to allow different limits per endpoint
        return sha1($limiter . '|' . $identifier . '|' . $request->path());
    }

    /**
     * Get the maximum number of attempts for the given limiter.
     */
    protected function getMaxAttempts(string $limiter): int
    {
        return match($limiter) {
            'auth' => 10,         // 10 auth requests per minute
            'profile' => 20,      // 20 profile updates per minute
            'web' => 100,         // 100 web requests per minute
            default => 100,
        };
    }

    /**
     * Get the decay seconds for the given limiter.
     */
    protected function getDecaySeconds(string $limiter): int
    {
        return match($limiter) {
            'auth' => 60,         // 1 minute
            'profile' => 60,      // 1 minute
            'web' => 60,          // 1 minute
            default => 60,
        };
    }
}
