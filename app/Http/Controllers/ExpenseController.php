<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Colocation;
use App\Models\Debt;
use App\Http\Requests\Expense\storeExpenseRequest;
use App\Http\Requests\Expense\DeleteExpenseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ExpenseController extends Controller
{
    /**
     * Store a newly created expense and calculate debts.
     */
    public function store(storeExpenseRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $colocation = Colocation::findOrFail($validated['colocation_id']);
            
            $payerId = $validated['payer_id'] ?? Auth::id();
            
            $expense = Expense::create([
                'title' => $validated['title'],
                'amount' => $validated['amount'],
                'expense_date' => now(),
                'colocation_id' => $colocation->id,
                'category_id' => $validated['category_id'],
                'payer_id' => $payerId,
            ]);

            $members = $colocation->users()->whereNull('memberships.left_at')->get();
            $nbMembers = $members->count();
            
            if ($nbMembers > 1) {
                $debtPerMember = $validated['amount'] / $nbMembers;

                foreach ($members as $member) {
                    if ($member->id === $payerId) continue;

                    $existingDebtToPayer = Debt::where('debtor_id', $member->id)
                        ->whereHas('expense', function($q) use ($payerId) {
                            $q->where('payer_id', $payerId);
                        })
                        ->where('paid', false)
                        ->first();
                    
                    $existingDebtFromPayer = Debt::where('debtor_id', $payerId)
                        ->whereHas('expense', function($q) use ($member) {
                            $q->where('payer_id', $member->id);
                        })
                        ->where('paid', false)
                        ->first();

                    if ($existingDebtToPayer) {
                        $existingDebtToPayer->increment('amount', $debtPerMember);
                    } elseif ($existingDebtFromPayer) {
                        $oldAmount = $existingDebtFromPayer->amount;
                        $diff = $oldAmount - $debtPerMember;
                        
                        if ($diff > 0) {
                            $existingDebtFromPayer->update(['amount' => $diff]);
                        } elseif ($diff < 0) {
                            $existingDebtFromPayer->delete();
                            Debt::create([
                                'amount' => abs($diff),
                                'paid' => false,
                                'expense_id' => $expense->id,
                                'debtor_id' => $member->id,
                            ]);
                        } else {
                            $existingDebtFromPayer->delete();
                        }
                    } else {
                        Debt::create([
                            'amount' => $debtPerMember,
                            'paid' => false,
                            'expense_id' => $expense->id,
                            'debtor_id' => $member->id,
                        ]);
                    }
                }
            }

            return redirect()->back()->with('success', 'Expense created successfully and debts calculated.');
        });
    }

    /**
     * Remove the specified expense and handle debt reversal.
     */
    public function destroy(DeleteExpenseRequest $request, Expense $expense)
    {
        return DB::transaction(function () use ($expense) {
            $paidDebts = $expense->debts()->where('paid', true)->get();
            
            foreach ($paidDebts as $paidDebt) {
                Debt::create([
                    'amount' => $paidDebt->amount,
                    'paid' => false,
                    'expense_id' => null,
                    'debtor_id' => $expense->payer_id,
                ]);
            }
            
            $expense->delete();

            return redirect()->back()->with('success', 'Expense deleted and debts adjusted.');
        });
    }

    /**
     * Mark a debt as paid.
     */
    public function markPaid(Debt $debt)
    {
        return DB::transaction(function () use ($debt) {
            $debt->update(['paid' => true]);
            
            $debt->debtor->increment('reputation');

            return redirect()->back()->with('success', 'Debt marked as paid.');
        });
    }
}
