<?php

namespace App\Policies;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Validation\Rules\In;

class ExpensePolicy
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
    public function view(User $user, Expense $expense): Response
    {
        if($user->isBanned()) return Response::deny('you are banne');

        if(!($user->colocations()->where('status', 'active')->where('colocations.id', $expense->colocation_id)->exists()))
        { return Response::deny('you are not a member in the colocation') ; }
        
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Colocation $colocation): Response
    {
        if($user->isBanned()) return Response::deny('you are banne');

        if(!($user->colocations()->where('status', 'active')->where('colocations.id', $colocation->id )->exists()))
        { return Response::deny('you are not a member in the colocation') ; }

        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Expense $expense): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Expense $expense): Response
    {
        if($user->isBanned()) return Response::deny('you are banned');

        if($expense->payer_id == $user->id) return Response::allow();

        return Response::deny("you are not allowed to delete this expense");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Expense $expense): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Expense $expense): Response
    {
        if($user->isBanned()) return Response::deny('you are banne');

        if($expense->payer_id === $user->id) return Response::allow();

        return Response::deny("you are not allowed to delete this expense");
    }
}
