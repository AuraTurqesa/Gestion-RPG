<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryMovementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'character_id' => Character::factory(),
            'item_id' => Item::factory(),
            'type' => fake()->randomElement(['LOOT', 'EQUIP', 'UNEQUIP', 'DROP']),
            'resume' => fake()->sentence(),
            'executed_at' => now(),
        ];
    }
}
