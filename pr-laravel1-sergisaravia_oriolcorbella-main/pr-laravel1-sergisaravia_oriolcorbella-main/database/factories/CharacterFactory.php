<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'level' => fake()->numberBetween(1, 100),
            'health' => fake()->numberBetween(50, 1000),
            'user_id' => User::factory(),
        ];
    }
}
