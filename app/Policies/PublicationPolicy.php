<?php

namespace App\Policies;

use App\Models\Publication;
use App\Models\User;

class PublicationPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Publication $publication): bool
    {
        // Allow if user is the author OR if user is an admin
        return $user->id === $publication->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Publication $publication): bool
    {
        // Same rule as update
        return $this->update($user, $publication);
    }
}
