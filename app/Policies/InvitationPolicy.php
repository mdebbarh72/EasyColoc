<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvitationPolicy
{
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
    public function view(User $user, Invitation $invitation): bool
    {
        // Owner of the colocation can view
        if ($user->colocations()->where('colocation_id', $invitation->colocation_id)->wherePivot('role', 'owner')->exists()) {
            return true;
        }

        // Recipient can view if email matches
        return $user->email === $invitation->email;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, ?\App\Models\Colocation $colocation = null): bool
    {
        if ($colocation) {
            return $user->colocations()
                ->where('colocation_id', $colocation->id)
                ->wherePivot('role', 'owner')
                ->whereNull('memberships.left_at')
                ->exists();
        }

        // Fallback for general check
        return $user->isOwner();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Invitation $invitation): bool
    {
        // No modification allowed
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Invitation $invitation): bool
    {
        // No deletion allowed
        return false;
    }

    /**
     * Determine whether the user can accept the invitation.
     */
    public function accept(User $user, Invitation $invitation): bool
    {
        // 1. Invitation must be pending
        if (!$invitation->pending()) {
            return false;
        }

        // 2. Invitation must not be expired
        if ($invitation->expired()) {
            return false;
        }

        // 3. Colocation must be active (not canceled)
        if (!$invitation->colocation->isActive()) {
            return false;
        }

        // 4. User must not already be in an active colocation
        return !$user->isActiveMemberOrOwner();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Invitation $invitation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Invitation $invitation): bool
    {
        return false;
    }
}
