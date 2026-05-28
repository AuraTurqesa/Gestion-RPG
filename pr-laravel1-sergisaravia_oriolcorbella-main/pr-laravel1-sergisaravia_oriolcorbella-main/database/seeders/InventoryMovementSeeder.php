<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryMovement;
use App\Models\Character;
use App\Models\Item;

class InventoryMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Recuperamos todos los personajes y objetos de la BD
        $allCharacters = Character::all();
        $allItems = Item::all();

        // Verificación de seguridad por si las tablas están vacías
        if ($allCharacters->isEmpty() || $allItems->isEmpty()) {
            $this->command->warn('No hay personajes u objetos para crear movimientos de inventario.');
            return;
        }

        // 1. Crear movimientos tipo LOOT
        InventoryMovement::factory()->count(30)->create([
            'character_id' => fn() => $allCharacters->random()->id,
            'item_id' => fn() => $allItems->random()->id,
            'type' => 'LOOT'
        ]);

        // 2. Crear movimientos tipo EQUIP
        InventoryMovement::factory()->count(10)->create([
            'character_id' => fn() => $allCharacters->random()->id,
            'item_id' => fn() => $allItems->whereIn('type', ['weapon', 'armor'])->random()->id,
            'type' => 'EQUIP'
        ]);

        // 3. Crear movimientos tipo DROP
        InventoryMovement::factory()->count(20)->create([
            'character_id' => fn() => $allCharacters->random()->id,
            'item_id' => fn() => $allItems->random()->id,
            'type' => 'DROP'
        ]);
    }
}