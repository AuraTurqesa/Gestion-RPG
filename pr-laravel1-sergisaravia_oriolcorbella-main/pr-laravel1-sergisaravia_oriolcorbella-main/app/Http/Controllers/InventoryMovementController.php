<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use App\Models\Character;
use App\Models\Item;
use App\Http\Requests\StoreInventoryMovementRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class InventoryMovementController extends Controller
{
    use AuthorizesRequests;

    /**
     * POST /inventory-movements
     * Registra un movimiento en MySQL (como pr).
     */
    public function store(StoreInventoryMovementRequest $request)
    {
        $data = $request->validated();
        $character = Character::findOrFail($data['character_id']);
        $this->authorize('update', $character);

        $item = Item::findOrFail($data['item_id']);

        //REGLA RPG: No puedes soltar o equipar lo que no tienes
        if (in_array($data['type'], ['DROP', 'EQUIP'])) {
            $hasItem = InventoryMovement::where('character_id', $character->id)
                ->where('item_id', $item->id)
                ->where('type', 'LOOT')
                ->exists();

            if (!$hasItem) {
                return response()->json(['message' => 'No tienes este objeto en tu inventario.'], 422);
            }
        }

        // REGLA RPG: No puedes equiparte dos veces en el mismo sitio
        if ($data['type'] === 'EQUIP') {
            $alreadyEquipped = InventoryMovement::where('character_id', $character->id)
                ->whereHas('item', function($query) use ($item) {
                    $query->where('slot', $item->slot);
                })
                ->whereIn('type', ['EQUIP', 'UNEQUIP'])
                ->latest()
                ->first();

            // Si el último movimiento en ese slot fue 'EQUIP', significa que el slot está ocupado
            if ($alreadyEquipped && $alreadyEquipped->type === 'EQUIP') {
                return response()->json([
                    'message' => "El slot {$item->slot} ya está ocupado. Debes desequipar el objeto actual primero."
                ], 422);
            }
        }

        // 3. Generación de resumen y guardado
        $accion = match ($data['type']) {
            'LOOT'    => 'ha obtenido',
            'DROP'    => 'ha perdido',
            'EQUIP'   => 'se ha equipado',
            'UNEQUIP' => 'se ha desequipado',
            default   => 'ha interactuado con',
        };

        $data['resume'] = "El jugador {$character->name} {$accion} el objeto {$item->name}.";
        $movement = InventoryMovement::create($data);

        return response()->json($movement, 201);
    }
}