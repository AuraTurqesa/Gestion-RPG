<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::factory()->count(6)->create([
            'type' => 'weapon',
            'slot' => 'weapon',
        ]);

        Item::factory()->count(4)->create([
            'type' => 'armor',
            'slot' => 'head',
        ]);

        Item::factory()->count(4)->create([
            'type' => 'armor',
            'slot' => 'body',
        ]);

        Item::factory()->count(6)->create([
            'type' => 'consumable',
            'slot' => 'nullable',
        ]);
    }
}
