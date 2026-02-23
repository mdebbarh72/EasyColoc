<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAdminData', User::class);

        $totalUsers = User::count();
        $activeColocations = Colocation::where('status', 'active')->count();
        $totalExpenses = Expense::sum('amount');
        $bannedUsersCount = User::whereNotNull('banned_at')->orWhere('status', 'banned')->count();

        $query = User::query();

        if ($request->has('search') && $request->search !== '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        $users = $query->where('id', '!=', auth()->id())
                       ->orderBy('id', 'desc')
                       ->paginate(10)
                       ->withQueryString();

        return view('admin.index', compact(
            'totalUsers', 
            'activeColocations', 
            'totalExpenses', 
            'bannedUsersCount', 
            'users'
        ));
    }

    public function toggleBan(User $user)
    {
        Gate::authorize('viewAdminData', User::class);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot ban yourself.');
        }

        if ($user->isBanned()) {
            $user->update([
                'status' => 'active',
                'banned_at' => null
            ]);
            $message = "User {$user->first_name} has been unbanned.";
        } else {
            $user->update([
                'status' => 'banned',
                'banned_at' => now()
            ]);
            $message = "User {$user->first_name} has been banned.";
        }

        return back()->with('success', $message);
    }
}
