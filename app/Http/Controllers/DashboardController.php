<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\Debt;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $reputation = $user->reputation;

        $globalExpenses = Debt::where('debtor_id', $user->id)
            ->where('paid', false)
            ->sum('amount');

        $activeColocations = $user->colocations()->where('colocations.status', 'active')->whereNull('memberships.left_at')->get();
        $colocationIds = $activeColocations->pluck('id');

        $recentExpenses = Expense::with(['payer', 'category', 'colocation'])
            ->whereIn('colocation_id', $colocationIds)
            ->latest()
            ->take(5)
            ->get();

        $activeColocation = $activeColocations->first();
        $colocationMembers = $activeColocation ? $activeColocation->users()->whereNull('memberships.left_at')->get() : collect([]);

        return view('dashboard', compact('reputation', 'globalExpenses', 'recentExpenses', 'activeColocation', 'colocationMembers'));
    }
}
