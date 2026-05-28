<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\InventoryMovement;
use App\Models\Item;
use App\Http\Requests\StoreCharacterRequest;
use App\Http\Requests\UpdateCharacterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CharacterController extends Controller
{
    /**
     * GET /characters
     */
    public function index(Request $request)
    {
        $characters = Character::where('user_id', $request->user()->id)
            ->with(['inventoryMovements.item'])
            ->orderBy('id', 'desc')
            ->get();

        if ($this->shouldReturnJson($request)) {
            $payload = $characters->map(function (Character $character) {
                $characterData = $character->toArray();
                $characterData['equipped'] = $this->getEquippedItems($character);

                return $characterData;
            });

            return response()->json($payload);
        }

        return view('character.index', compact('characters'));
    }

    /**
     * GET /characters/create
     */
    public function create()
    {
        return view('character.create');
    }

    /**
     * POST /characters
     */
    public function store(StoreCharacterRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('characters', 'public');
        }

        $character = Character::create(array_merge($data, [
            'user_id' => $request->user()->id,
        ]));

        if ($this->shouldReturnJson($request)) {
            return response()->json($character, 201);
        }

        return redirect()
            ->route('character.index')
            ->with('success', 'Personaje creado correctamente.');
    }

    /**
     * GET /characters/{character}
     */
    public function show(Request $request, Character $character)
    {
        abort_if($character->user_id !== $request->user()->id, 403, 'No autorizado.');

        $characterData = $character->toArray();
        $characterData['equipped'] = $this->getEquippedItems($character);

        if ($this->shouldReturnJson($request)) {
            return response()->json($characterData);
        }

        return view('character.show', compact('character'));
    }

    /**
     * GET /characters/{character}/edit
     */
    public function edit(Character $character)
    {
        return view('character.edit', compact('character'));
    }

    /**
     * PUT/PATCH /characters/{character}
     */
  public function update(UpdateCharacterRequest $request, Character $character) 
    {
        abort_if($character->user_id !== $request->user()->id, 403, 'No autorizado.');

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $oldImagePath = $character->image_path;
            $data['image_path'] = $request->file('image')->store('characters', 'public');

            if ($oldImagePath) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        $character->update($data);

        if ($this->shouldReturnJson($request)) {
            return response()->json($character);
        }

        return redirect()
            ->route('character.show', $character->id) 
            ->with('success', 'Personaje actualizado correctamente.');
    }

    /**
     * DELETE /characters/{character}
     */
    public function destroy(Request $request, Character $character)
    {
        abort_if($character->user_id !== $request->user()->id, 403, 'No autorizado.');

        if ($character->image_path) {
            Storage::disk('public')->delete($character->image_path);
        }

        $character->delete();

        if ($this->shouldReturnJson($request)) {
            return response()->json(null, 204);
        }

        return redirect()
            ->route('character.index')
            ->with('success', 'Personaje eliminado correctamente.');
    }

    /**
     * GET /characters/{character}/inventory
     */
    public function inventory(Request $request, Character $character)
    {
        abort_if($character->user_id !== $request->user()->id, 403, 'No autorizado.');

        $movements = $character->inventoryMovements()
            ->with('item')
            ->orderBy('created_at', 'asc')
            ->get();

        $inventory = [];

        foreach ($movements as $movement) {
            $itemId = $movement->item_id;
            if (!$movement->item) continue;

            switch ($movement->type) {
                case 'LOOT':
                    $inventory[$itemId] = [
                        'id' => $movement->item->id,
                        'name' => $movement->item->name,
                        'type' => $movement->item->type,
                        'slot' => $movement->item->slot,
                        'is_equipped' => false,
                    ];
                    break;
                case 'DROP':
                    unset($inventory[$itemId]);
                    break;
                case 'EQUIP':
                    if (isset($inventory[$itemId])) $inventory[$itemId]['is_equipped'] = true;
                    break;
                case 'UNEQUIP':
                    if (isset($inventory[$itemId])) $inventory[$itemId]['is_equipped'] = false;
                    break;
            }
        }

        $items = array_values($inventory);
        $equipped = $this->getEquippedItems($character);
        $selectableItems = Item::query()
            ->orderBy('name')
            ->get(['id', 'name', 'slot', 'type']);

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'character_id' => $character->id,
                'character_name' => $character->name,
                'inventory' => $items,
                'equipped' => $equipped,
            ]);
        }

        return view('character.inventory', compact('character', 'items', 'equipped', 'selectableItems'));
    }

    /**
     * POST /character/{character}/inventory
     * Permite seleccionar que item queda equipado por slot.
     */
    public function updateInventoryEquipment(Request $request, Character $character)
    {
        abort_if($character->user_id !== $request->user()->id, 403, 'No autorizado.');

        $validated = $request->validate([
            'head_item_id' => ['nullable', 'integer', 'exists:items,id'],
            'body_item_id' => ['nullable', 'integer', 'exists:items,id'],
            'weapon_item_id' => ['nullable', 'integer', 'exists:items,id'],
        ]);

        $movements = $character->inventoryMovements()
            ->with('item')
            ->orderBy('created_at', 'asc')
            ->get();

        $inventoryItemIds = [];
        foreach ($movements as $movement) {
            if (!$movement->item) {
                continue;
            }

            if ($movement->type === 'LOOT') {
                $inventoryItemIds[$movement->item_id] = true;
            } elseif ($movement->type === 'DROP') {
                unset($inventoryItemIds[$movement->item_id]);
            }
        }

        $currentlyEquipped = collect($this->getEquippedItems($character))
            ->mapWithKeys(fn ($item, $slot) => [$slot => $item['id'] ?? null]);

        $desiredBySlot = [
            'head' => $currentlyEquipped['head'],
            'body' => $currentlyEquipped['body'],
            'weapon' => $currentlyEquipped['weapon'],
        ];

        if ($request->has('head_item_id')) {
            $desiredBySlot['head'] = $validated['head_item_id'] ?? null;
        }
        if ($request->has('body_item_id')) {
            $desiredBySlot['body'] = $validated['body_item_id'] ?? null;
        }
        if ($request->has('weapon_item_id')) {
            $desiredBySlot['weapon'] = $validated['weapon_item_id'] ?? null;
        }

        foreach ($desiredBySlot as $slot => $itemId) {
            if ($itemId !== null) {
                $item = Item::find($itemId);
                if (!$item || $item->slot !== $slot) {
                    return back()->withErrors(['inventory' => "El objeto seleccionado para {$slot} no es valido."]);
                }

                if (!isset($inventoryItemIds[$itemId])) {
                    InventoryMovement::create([
                        'character_id' => $character->id,
                        'item_id' => $itemId,
                        'type' => 'LOOT',
                        'resume' => "El jugador {$character->name} ha obtenido el objeto {$item->name}.",
                        'executed_at' => now(),
                    ]);
                    $inventoryItemIds[$itemId] = true;
                }
            }

            $currentItemId = $currentlyEquipped[$slot];
            if ($currentItemId && $currentItemId !== $itemId) {
                InventoryMovement::create([
                    'character_id' => $character->id,
                    'item_id' => $currentItemId,
                    'type' => 'UNEQUIP',
                    'resume' => "El jugador {$character->name} se ha desequipado un objeto del slot {$slot}.",
                    'executed_at' => now(),
                ]);
            }

            if ($itemId && $currentItemId !== $itemId) {
                $itemName = $movements->firstWhere('item_id', $itemId)?->item?->name ?? 'objeto';
                InventoryMovement::create([
                    'character_id' => $character->id,
                    'item_id' => $itemId,
                    'type' => 'EQUIP',
                    'resume' => "El jugador {$character->name} se ha equipado el objeto {$itemName}.",
                    'executed_at' => now(),
                ]);
            }
        }

        return redirect()
            ->route('character.inventory', $character)
            ->with('success', 'Equipo actualizado correctamente.');
    }

    /**
     * Construye el equipo actualmente equipado por slot.
     */
    private function getEquippedItems(Character $character): array
    {
        $movements = $character->inventoryMovements
            ->whereIn('type', ['EQUIP', 'UNEQUIP'])
            ->sortByDesc(fn ($movement) => $movement->executed_at ?? $movement->created_at);

        $currentlyEquipped = $movements->unique('item_id')
            ->filter(fn ($movement) => $movement->type === 'EQUIP');

        return [
            'head' => optional($currentlyEquipped->first(fn ($movement) => $movement->item?->slot === 'head'))->item,
            'body' => optional($currentlyEquipped->first(fn ($movement) => $movement->item?->slot === 'body'))->item,
            'weapon' => optional($currentlyEquipped->first(fn ($movement) => $movement->item?->slot === 'weapon'))->item,
        ];
    }
}