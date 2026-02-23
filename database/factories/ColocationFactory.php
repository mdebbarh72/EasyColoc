<?php

namespace Database\Factories;

use App\Models\Colocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColocationFactory extends Factory
{
    protected $model = Colocation::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word() . ' Coloc',
            'status' => 'active',
        ];
    }
}
