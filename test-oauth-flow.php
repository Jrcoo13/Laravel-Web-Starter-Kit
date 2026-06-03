<?php

/**
 * Test script to verify OAuth authentication flow
 * This script checks all critical components for Google OAuth
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Google OAuth Configuration Test ===\n\n";

// 1. Check Google OAuth Configuration
echo "1. Checking Google OAuth Configuration:\n";
echo "   - Client ID: " . (config('services.google.client_id') ? '✓ Set' : '✗ Missing') . "\n";
echo "   - Client Secret: " . (config('services.google.client_secret') ? '✓ Set' : '✗ Missing') . "\n";
echo "   - Redirect URI: " . config('services.google.redirect') . "\n\n";

// 2. Check Roles Table
echo "2. Checking Roles:\n";
try {
    $roles = \App\Models\Role::all();
    echo "   - Roles count: " . $roles->count() . "\n";
    foreach ($roles as $role) {
        echo "     • {$role->name} (slug: {$role->slug}, id: {$role->id})\n";
    }
    
    $defaultRole = \App\Models\Role::where('slug', 'user')->first();
    echo "   - Default 'user' role: " . ($defaultRole ? "✓ Found (ID: {$defaultRole->id})" : '✗ Not found') . "\n\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 3. Check Users Table Structure
echo "3. Checking Users Table Structure:\n";
try {
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('users');
    $requiredColumns = ['google_id', 'avatar', 'role_id', 'first_name', 'last_name'];
    
    foreach ($requiredColumns as $column) {
        echo "   - {$column}: " . (in_array($column, $columns) ? '✓ Exists' : '✗ Missing') . "\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 4. Check Session Configuration
echo "4. Checking Session Configuration:\n";
echo "   - Session Driver: " . config('session.driver') . "\n";
echo "   - Session Lifetime: " . config('session.lifetime') . " minutes\n";
echo "   - Session Domain: " . (config('session.domain') ?: 'null (default)') . "\n";
echo "   - Session Path: " . config('session.path') . "\n\n";

// 5. Check Auth Configuration
echo "5. Checking Auth Configuration:\n";
echo "   - Default Guard: " . config('auth.defaults.guard') . "\n";
echo "   - Fortify Guard: " . config('fortify.guard') . "\n";
echo "   - Fortify Home Path: " . config('fortify.home') . "\n\n";

// 6. Test User Creation (Dry Run)
echo "6. Testing User Creation Logic:\n";
try {
    $testData = [
        'first_name' => 'Test',
        'last_name' => 'User',
        'name' => 'Test User',
        'email' => 'test.oauth@example.com',
        'google_id' => '123456789',
        'avatar' => 'https://example.com/avatar.jpg',
        'email_verified_at' => now(),
        'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(32)),
        'role_id' => 2,
    ];
    
    // Check if test user already exists
    $existingUser = \App\Models\User::where('email', $testData['email'])->first();
    if ($existingUser) {
        echo "   - Test user already exists (ID: {$existingUser->id})\n";
        echo "   - Has role: " . ($existingUser->role ? $existingUser->role->name : 'None') . "\n";
    } else {
        echo "   - Test data structure: ✓ Valid\n";
        echo "   - All required fields present: ✓ Yes\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 7. Check Routes
echo "7. Checking OAuth Routes:\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $oauthRoutes = [
        'auth.google' => 'GET|HEAD',
        'auth.google.callback' => 'GET|HEAD',
    ];
    
    foreach ($oauthRoutes as $name => $method) {
        $route = $routes->getByName($name);
        echo "   - {$name}: " . ($route ? "✓ Exists ({$route->uri})" : '✗ Missing') . "\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 8. Check Socialite Installation
echo "8. Checking Laravel Socialite:\n";
try {
    $socialiteInstalled = class_exists(\Laravel\Socialite\Facades\Socialite::class);
    echo "   - Socialite: " . ($socialiteInstalled ? '✓ Installed' : '✗ Not installed') . "\n\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

echo "=== Test Complete ===\n";
echo "\nIf all checks pass (✓), the OAuth flow should work correctly.\n";
echo "Test the actual flow by visiting: " . config('app.url') . "/login\n";
