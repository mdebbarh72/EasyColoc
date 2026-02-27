<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\User;
use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    /**
     * User voluntarily leaves the colocation.
     */
    public function leave(Colocation $colocation)
    {
        return DB::transaction(function () use ($colocation) {
            $user = Auth::user();
            
            $membership = $colocation->users()->wherePivot('user_id', $user->id)->whereNull('memberships.left_at')->first();
            if (!$membership) {
                return redirect()->back()->with('error', 'You are not an active member of this colocation.');
            }

            if ($membership->pivot->role === 'owner') {
                return redirect()->back()->with('error', 'The owner cannot leave. Cancel the colocation instead.');
            }

            $unpaidDebts = Debt::where('debtor_id', $user->id)
                ->where('paid', false)
                ->whereHas('expense', function($q) use ($colocation) {
                    $q->where('colocation_id', $colocation->id);
                })->get();

            $numDebts = $unpaidDebts->count();

            if ($numDebts > 0) {
                $user->decrement('reputation', $numDebts);
            }

            $remainingMembers = $colocation->users()->whereNull('memberships.left_at')->where('users.id', '!=', $user->id)->get();
            $numRemaining = $remainingMembers->count();

            foreach ($unpaidDebts as $debt) {
                if ($numRemaining > 0) {
                    $splitAmount = $debt->amount / $numRemaining;
                    $expenseId = $debt->expense_id;
                    $originalPayerId = $debt->expense->payer_id;

                    foreach ($remainingMembers as $remainingMember) {
                        if ($remainingMember->id === $originalPayerId) {
                            continue;
                        }

                        $existingDebt = Debt::where('debtor_id', $remainingMember->id)
                            ->where('expense_id', $expenseId)
                            ->where('paid', false)
                            ->first();

                        if ($existingDebt) {
                            $existingDebt->increment('amount', $splitAmount);
                        } else {
                            Debt::create([
                                'amount' => $splitAmount,
                                'paid' => false,
                                'expense_id' => $expenseId,
                                'debtor_id' => $remainingMember->id,
                            ]);
                        }
                    }
                }
                
                $debt->delete();
            }

            $colocation->users()->updateExistingPivot($user->id, ['left_at' => now()]);

            return redirect()->route('dashboard')->with('success', 'You have left the colocation. Your debts have been re-assigned.');
        });
    }

    /**
     * Owner removes a user from the colocation.
     */
    public function remove(Colocation $colocation, User $user)
    {
        return DB::transaction(function () use ($colocation, $user) {
            $owner = Auth::user();

            $ownerMembership = $colocation->users()->wherePivot('user_id', $owner->id)->wherePivot('role', 'owner')->whereNull('memberships.left_at')->first();
            if (!$ownerMembership) {
                return redirect()->back()->with('error', 'Only the owner can remove members.');
            }

            $targetMembership = $colocation->users()->wherePivot('user_id', $user->id)->whereNull('memberships.left_at')->first();
            if (!$targetMembership) {
                return redirect()->back()->with('error', 'User is not an active member.');
            }

            if ($targetMembership->pivot->role === 'owner') {
                return redirect()->back()->with('error', 'Cannot remove the owner.');
            }

            $unpaidDebts = Debt::where('debtor_id', $user->id)
                ->where('paid', false)
                ->whereHas('expense', function($q) use ($colocation) {
                    $q->where('colocation_id', $colocation->id);
                })->get();

            foreach ($unpaidDebts as $debt) {
                $originalPayerId = $debt->expense->payer_id;

                if ($originalPayerId === $owner->id) {
                    $debt->delete();
                } else {
                    $existingOwnerDebt = Debt::where('debtor_id', $owner->id)
                        ->where('expense_id', $debt->expense_id)
                        ->where('paid', false)
                        ->first();

                    if ($existingOwnerDebt) {
                        $existingOwnerDebt->increment('amount', $debt->amount);
                        $debt->delete();
                    } else {
                        $debt->update(['debtor_id' => $owner->id]);
                    }
                }
            }

            $colocation->users()->updateExistingPivot($user->id, ['left_at' => now()]);

            return redirect()->back()->with('success', "Member removed. Their debts have been transferred to you.");
        });
    }
}
