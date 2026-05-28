<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Character;
use App\Models\Item;
use App\Models\InventoryMovement;
use App\Models\Log;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ItemSeeder::class,
            CharacterSeeder::class,
            InventoryMovementSeeder::class,
            LogsSeeder::class
        ]);
    }
}
