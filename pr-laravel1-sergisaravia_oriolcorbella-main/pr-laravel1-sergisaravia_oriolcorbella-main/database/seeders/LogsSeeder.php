<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Log;
use App\Models\Item;
use App\Models\Character;
use App\Models\User;
use App\Models\InventoryMovement;

class LogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Recuperamos los datos necesarios de la BD
        $allItems = Item::all();
        $allCharacters = Character::all();
        
        // Buscamos al admin (el primero que creamos en UserSeeder)
        $admin = User::where('role', 'admin')->first();

        // 2. Logs de Items
        foreach ($allItems as $item) {
            Log::create([
                'action' => 'item_created',
                'user_id' => $admin ? $admin->id : null, // Evitamos error si no hay admin
                'metadata' => [
                    'itemId' => $item->id,
                    'name' => $item->name,
                    'itemType' => $item->type
                ]
            ]);
        }

        // 3. Logs de Personatges
        foreach ($allCharacters as $char) {
            Log::create([
                'action' => 'character_created',
                'user_id' => $char->user_id,
                'metadata' => [
                    'characterId' => $char->id,
                    'name' => $char->name
                ]
            ]);
        }

        // 4. Logs de Moviments (els 40 primers)
        // Usamos Eager Loading (with) para no saturar la base de datos con consultas
        $movementsToLog = InventoryMovement::with('character')->take(40)->get();
        
        foreach ($movementsToLog as $move) {
            Log::create([
                'action' => 'inventory_movement_created',
                'user_id' => $move->character->user_id,
                'metadata' => [
                    'characterId' => $move->character_id,
                    'itemId' => $move->item_id,
                    'movementType' => $move->type
                ]
            ]);
        }
    }
}