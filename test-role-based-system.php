<?php

/**
 * Test script to verify role-based layout system
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Role-Based Layout System Test ===\n\n";

// 1. Check Roles Exist
echo "1. Checking Roles:\n";
try {
    $adminRole = \App\Models\Role::where('slug', 'admin')->first();
    $userRole = \App\Models\Role::where('slug', 'user')->first();
    
    echo "   - Admin role: " . ($adminRole ? "✓ Found (ID: {$adminRole->id})" : '✗ Missing') . "\n";
    echo "   - User role: " . ($userRole ? "✓ Found (ID: {$userRole->id})" : '✗ Missing') . "\n\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 2. Check Users by Role
echo "2. Checking Users by Role:\n";
try {
    $adminUsers = \App\Models\User::whereHas('role', function($q) {
        $q->where('slug', 'admin');
    })->count();
    
    $regularUsers = \App\Models\User::whereHas('role', function($q) {
        $q->where('slug', 'user');
    })->count();
    
    echo "   - Admin users: {$adminUsers}\n";
    echo "   - Regular users: {$regularUsers}\n";
    echo "   - Total: " . \App\Models\User::count() . "\n\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 3. Check Routes
echo "3. Checking Routes:\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $requiredRoutes = ['dashboard', 'home'];
    
    foreach ($requiredRoutes as $name) {
        $route = $routes->getByName($name);
        echo "   - {$name}: " . ($route ? "✓ Exists ({$route->uri})" : '✗ Missing') . "\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 4. Check Middleware
echo "4. Checking Middleware:\n";
try {
    $app = app();
    $router = $app->make('router');
    $middlewareGroups = [
        'role.redirect' => \App\Http\Middleware\RedirectBasedOnRole::class,
        'admin' => \App\Http\Middleware\AdminOnly::class,
    ];
    
    foreach ($middlewareGroups as $alias => $class) {
        $exists = class_exists($class);
        echo "   - {$alias}: " . ($exists ? "✓ Class exists" : '✗ Missing') . "\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 5. Check Custom Login Response
echo "5. Checking Custom Login Response:\n";
try {
    $loginResponse = app(\Laravel\Fortify\Contracts\LoginResponse::class);
    $isCustom = $loginResponse instanceof \App\Http\Responses\LoginResponse;
    echo "   - Custom LoginResponse: " . ($isCustom ? "✓ Registered" : '✗ Using default') . "\n\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 6. Test Sample User Access
echo "6. Testing Sample User Access:\n";
try {
    $sampleUser = \App\Models\User::with('role')->first();
    
    if ($sampleUser) {
        echo "   - Sample user: {$sampleUser->email}\n";
        echo "   - Role: " . ($sampleUser->role ? $sampleUser->role->name . " ({$sampleUser->role->slug})" : 'No role') . "\n";
        
        $expectedHome = $sampleUser->role && $sampleUser->role->slug === 'admin' ? '/dashboard' : '/home';
        echo "   - Expected redirect: {$expectedHome}\n";
    } else {
        echo "   - No users found in database\n";
    }
    echo "\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

// 7. Check Frontend Files
echo "7. Checking Frontend Files:\n";
$frontendFiles = [
    'resources/js/components/admin-sidebar.tsx',
    'resources/js/components/user-sidebar.tsx',
    'resources/js/components/app-sidebar.tsx',
    'resources/js/hooks/use-role.ts',
    'resources/js/pages/home.tsx',
    'resources/js/pages/dashboard.tsx',
];

foreach ($frontendFiles as $file) {
    $exists = file_exists(__DIR__ . '/' . $file);
    $shortName = basename($file);
    echo "   - {$shortName}: " . ($exists ? "✓ Exists" : '✗ Missing') . "\n";
}
echo "\n";

echo "=== Test Complete ===\n\n";

// Summary
echo "📊 Summary:\n";
echo "   - Run 'npm run build' to compile frontend changes\n";
echo "   - Test admin access: Login with admin user → should see /dashboard\n";
echo "   - Test user access: Login with user → should see /home\n";
echo "   - Both roles have access to profile/account settings in sidebar\n\n";

echo "🧪 To manually test:\n";
echo "   1. php artisan serve\n";
echo "   2. Visit http://127.0.0.1:8000/login\n";
echo "   3. Login and verify you're redirected based on role\n";
