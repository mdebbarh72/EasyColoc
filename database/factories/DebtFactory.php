<?php

namespace Database\Factories;

use App\Models\Debt;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DebtFactory extends Factory
{
    protected $model = Debt::class;

    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 1, 100),
            'paid' => fake()->boolean(),
            'expense_id' => Expense::factory(),
            'debtor_id' => User::factory(),
        ];
    }
}
