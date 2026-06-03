<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine if the user can view the profile photo.
     * 
     * For now, any authenticated user can view any profile photo.
     * You can customize this based on your needs (e.g., friends only, team members, etc.)
     */
    public function viewProfilePhoto(User $authenticatedUser, User $user): bool
    {
        // Allow all authenticated users to view profile photos
        // Customize this logic based on your requirements:
        // - return $authenticatedUser->id === $user->id; // Only own photo
        // - return $authenticatedUser->isInSameTeamAs($user); // Team members only
        // - return $authenticatedUser->isFriendsWith($user); // Friends only
        
        return true;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
