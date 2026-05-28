<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        $type = fake()->randomElement(['weapon', 'armor', 'consumable']);

        $slot = match ($type) {
            'weapon' => 'weapon',
            'armor' => fake()->randomElement(['head', 'body']),
            default => 'nullable',
        };

        return [
                'name' => fake()->unique()->word(),
                'type' => $type,
                'slot' => $slot,
                'power' => fake()->numberBetween(0,30),
        ];
    }
}
