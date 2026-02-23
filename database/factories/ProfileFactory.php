<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'user_name' => fake()->userName(),
            'bio' => fake()->paragraph(),
            'picture' => fake()->imageUrl(200, 200, 'people'),
        ];
    }
}
