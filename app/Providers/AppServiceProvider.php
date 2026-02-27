<?php

namespace App\Providers;

use App\Policies\ExpensePolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Expense;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected $policies= [Expense::class => ExpensePolicy::class];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            if ($user->isBanned()) {
                return false;
            }
        });

        Gate::policy(\App\Models\Expense::class, \App\Policies\ExpensePolicy::class);
        Gate::define('delete-expense', [\App\Policies\ExpensePolicy::class, 'delete']); // Keep for backward compatibility if needed elsewhere

    }
}

