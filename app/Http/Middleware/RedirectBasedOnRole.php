<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        $role = $user->role;

        // Admin accessing dashboard - allow
        if ($role && $role->slug === 'admin' && $request->is('dashboard')) {
            return $next($request);
        }

        // User accessing home - allow
        if ($role && $role->slug === 'user' && $request->is('home')) {
            return $next($request);
        }

        // Admin trying to access home - redirect to dashboard
        if ($role && $role->slug === 'admin' && $request->is('home')) {
            return redirect()->route('dashboard');
        }

        // User trying to access dashboard or admin routes - redirect to home
        if ($role && $role->slug === 'user' && ($request->is('dashboard') || $request->is('admin/*'))) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
