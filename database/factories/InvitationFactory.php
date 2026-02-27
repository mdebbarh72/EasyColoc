<?php

namespace Database\Factories;

use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvitationFactory extends Factory
{
    protected $model = Invitation::class;

    public function definition(): array
    {
        return [
            'email' => fake()->safeEmail(),
            'token' => Str::random(40),
            'expires_at' => now()->addDays(7),
            'accepted_at' => null,
            'denied_at' => null,
            'colocation_id' => Colocation::factory(),
            'status' => 'pending',
        ];
    }
}
