<?php

use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\ProfilePhotoController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('welcome');

// Google OAuth Routes
Route::middleware('guest')->group(function () {
    Route::get('auth/google', [OAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [OAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// Authenticated routes
Route::middleware(['auth', 'verified', 'role.redirect'])->group(function () {
    // Admin dashboard
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
    
    // User home page  
    Route::inertia('home', 'home')->name('home');
    
    // Secure profile photo route - only accessible to authenticated users
    Route::get('users/{user}/profile-photo', [ProfilePhotoController::class, 'show'])
        ->name('profile-photo.show')
        ->middleware('rate.limit.web:web');
});

// Admin-only routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::inertia('users', 'admin/users')->name('users');
    Route::inertia('violations', 'admin/violations')->name('violations');
    Route::inertia('folders', 'admin/folders')->name('folders');
    Route::inertia('roles', 'admin/roles')->name('roles');
    Route::inertia('audit-trails', 'admin/audit-trails')->name('audit-trails');
    Route::inertia('settings', 'admin/settings')->name('settings');
});

require __DIR__.'/settings.php';
