<?php

namespace App\Policies;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ColocationPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): ?Response
    {
        if ($user->isBanned()) {
            return Response::deny('Your account has been banned and you cannot perform this action.');
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Colocation $colocation): Response
    {
        return $colocation->users()->where('user_id', $user->id)->exists()
            ? Response::allow()
            : Response::deny('You are not a member of this colocation.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return ! $user->isActiveMemberOrOwner()
            ? Response::allow()
            : Response::deny('You are already part of an active colocation. You must leave or cancel it before starting a new one.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Colocation $colocation): Response
    {
        $isOwner = $colocation->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'owner')
            ->whereNull('memberships.left_at')
            ->exists();

        return $isOwner 
            ? Response::allow() 
            : Response::deny('Only the colocation owner can modify these settings.');
    }

    /**
     * Determine whether the user can delete (cancel) the model.
     */
    public function delete(User $user, Colocation $colocation): Response
    {
        // Must be owner
        $isOwner = $colocation->users()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'owner')
            ->whereNull('memberships.left_at')
            ->exists();

        if (! $isOwner) {
            return Response::deny('Only the colocation owner can cancel it.');
        }

        // Must be the only member/owner
        $activeMembersCount = $colocation->users()
            ->whereNull('memberships.left_at')
            ->count();

        return $activeMembersCount === 1
            ? Response::allow()
            : Response::deny('You cannot cancel this colocation while other members are still present.');
    }
}
