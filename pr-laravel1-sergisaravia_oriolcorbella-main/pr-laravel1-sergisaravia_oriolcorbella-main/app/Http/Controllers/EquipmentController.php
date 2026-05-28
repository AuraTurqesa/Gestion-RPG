<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EquipmentController extends Controller
{
    use AuthorizesRequests;

        /**
        * GET /characters/{id}/equipment
        * Retorna el equipo actualmente equipado por el personaje.
        */  
    public function index($id)
    {
        $character = Character::findOrFail($id);

        $this->authorize('view', $character);

        // 3. Obtenemos movimientos
        $movements = $character->inventoryMovements()
            ->with('item')
            ->whereIn('type', ['EQUIP', 'UNEQUIP'])
            ->orderBy('executed_at', 'desc')
            ->get();

        $currentlyEquipped = $movements->unique('item_id')
            ->filter(fn($m) => $m->type === 'EQUIP');

        // 5. Respuesta estructurada
        return response()->json([
            'character_id'   => $character->id,
            'character_name' => $character->name,
            'equipment' => [
                'head'   => $currentlyEquipped->first(fn($m) => $m->item->slot === 'head')->item ?? null,
                'body'   => $currentlyEquipped->first(fn($m) => $m->item->slot === 'body')->item ?? null,
                'weapon' => $currentlyEquipped->first(fn($m) => $m->item->slot === 'weapon')->item ?? null,
            ]
        ]);
    }
}