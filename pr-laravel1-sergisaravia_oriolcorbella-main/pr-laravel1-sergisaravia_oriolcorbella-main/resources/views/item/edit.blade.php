@extends('layouts.app')

@section('title', 'Editar ítem')

@section('content')
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Editar ítem</h1>

    <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name', $item->name) }}" required
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="type" class="mb-1 block text-sm font-medium text-slate-700">Tipo</label>
                <select id="type" name="type" required class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
                    <option value="weapon" {{ old('type', $item->type) == 'weapon' ? 'selected' : '' }}>Weapon</option>
                    <option value="armor" {{ old('type', $item->type) == 'armor' ? 'selected' : '' }}>Armor</option>
                    <option value="consumable" {{ old('type', $item->type) == 'consumable' ? 'selected' : '' }}>Consumable</option>
                </select>
            </div>

            <div>
                <label for="slot" class="mb-1 block text-sm font-medium text-slate-700">Slot</label>
                <select id="slot" name="slot" class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
                    <option value="nullable" {{ old('slot', $item->slot) == 'nullable' ? 'selected' : '' }}>Sin slot (nullable)</option>
                    <option value="head" {{ old('slot', $item->slot) == 'head' ? 'selected' : '' }}>Head</option>
                    <option value="body" {{ old('slot', $item->slot) == 'body' ? 'selected' : '' }}>Body</option>
                    <option value="weapon" {{ old('slot', $item->slot) == 'weapon' ? 'selected' : '' }}>Weapon</option>
                </select>
            </div>
        </div>

        <div>
            <label for="power" class="mb-1 block text-sm font-medium text-slate-700">Poder (0 - 30)</label>
            <input id="power" name="power" type="number" min="0" max="30" value="{{ old('power', $item->power) }}" required
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div>
            <label for="image" class="mb-1 block text-sm font-medium text-slate-700">Nueva imagen (opcional)</label>
            <input id="image" name="image" type="file" accept="image/*"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
                Actualizar ítem
            </button>
            <a href="{{ route('items.show', $item) }}" class="text-sm font-semibold text-slate-700 hover:underline">Cancelar</a>
        </div>
    </form>
@endsection
