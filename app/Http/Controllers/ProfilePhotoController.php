<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProfilePhotoController extends Controller
{
    /**
     * Serve a user's profile photo from private storage.
     * 
     * This ensures profile photos are only accessible to authenticated users
     * and implements proper access control.
     */
    public function show(Request $request, User $user): StreamedResponse
    {
        // Security check: Only allow access if authenticated
        if (!$request->user()) {
            abort(403, 'Unauthorized access to profile photo.');
        }

        // Policy check: Verify user can view this profile photo
        if (!Gate::allows('viewProfilePhoto', $user)) {
            abort(403, 'You are not authorized to view this profile photo.');
        }

        // Check if user has a profile photo
        if (!$user->profile_photo_path) {
            abort(404, 'Profile photo not found.');
        }

        // Verify the file exists in private storage
        if (!Storage::disk('local')->exists($user->profile_photo_path)) {
            abort(404, 'Profile photo file not found.');
        }

        // Get the file from private storage
        $path = Storage::disk('local')->path($user->profile_photo_path);
        
        // Determine MIME type
        $mimeType = Storage::disk('local')->mimeType($user->profile_photo_path);

        // Return the file with proper headers and caching
        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'private, max-age=3600', // Cache for 1 hour
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
