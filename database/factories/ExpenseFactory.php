<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'amount' => fake()->randomFloat(2, 5, 500),
            'expense_date' => fake()->date(),
            'colocation_id' => Colocation::factory(),
            'category_id' => Category::factory(),
            'payer_id' => User::factory(),
        ];
    }
}
