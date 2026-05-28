<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * GET /items
     * Muestra la lista de items.
     */
    public function index(Request $request)
    {
        $items = Item::query()
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        if ($this->shouldReturnJson($request)) {
            return response()->json($items);
        }

        return view('item.index', compact('items'));
    }

    /**
     * GET /items/deleted
     * Muestra la lista de items eliminados (solo admin).
     */
    public function deleted(Request $request)
    {
        $items = Item::onlyTrashed()
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        if ($this->shouldReturnJson($request)) {
            return response()->json($items);
        }

        return view('item.deleted', compact('items'));
    }

    /**
     * GET /items/create
     */
    public function create()
    {
        return view('item.create');
    }

    /**
     * POST /items
     */
    public function store(StoreItemRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('items', 'public');
        }

        $item = Item::create($data);

        if ($this->shouldReturnJson($request)) {
            return response()->json($item, 201);
        }

        return redirect()
            ->route('items.index')
            ->with('success', 'Item creado correctamente.');
    }

    /**
     * GET /items/{item}
     */
    public function show(Request $request, Item $item)
    {
        if ($this->shouldReturnJson($request)) {
            return response()->json($item);
        }

        return view('item.show', compact('item'));
    }

    /**
     * GET /items/{item}/edit
     */
    public function edit(Item $item)
    {
        return view('item.edit', compact('item'));
    }

    /**
     * PUT/PATCH /items/{item}
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('items', 'public');
        }

        $item->update($data);

        if ($this->shouldReturnJson($request)) {
            return response()->json($item);
        }

        return redirect()
            ->route('items.show', $item->id)
            ->with('success', 'Item actualizado correctamente.');
    }

    /**
     * DELETE /items/{item}
     */
    public function destroy(Request $request, Item $item)
    {
        $item->delete();

        if ($this->shouldReturnJson($request)) {
            return response()->json(null, 204);
        }

        return redirect()
            ->route('items.index')
            ->with('success', 'Item eliminado correctamente.');
    }

    /**
     * POST /items/{id}/restore
     * Método adicional siguiendo la lógica de recuperación de soft deletes
     */
    public function restore(Request $request, $id)
    {
        $item = Item::withTrashed()->findOrFail($id);
        $item->restore();

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'message' => 'Item restaurado correctamente',
                'item' => $item
            ]);
        }

        return redirect()
            ->route('items.deleted')
            ->with('success', 'Item restaurado correctamente.');
    }
}