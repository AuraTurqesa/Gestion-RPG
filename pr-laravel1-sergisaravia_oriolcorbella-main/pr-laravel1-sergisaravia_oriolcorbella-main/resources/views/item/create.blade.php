@extends('layouts.app')

@section('title', 'Crear ítem')

@section('content')
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Crear nuevo ítem</h1>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="type" class="mb-1 block text-sm font-medium text-slate-700">Tipo (Type)</label>
                <select id="type" name="type" required class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
                    <option value="weapon" {{ old('type') == 'weapon' ? 'selected' : '' }}>Weapon</option>
                    <option value="armor" {{ old('type') == 'armor' ? 'selected' : '' }}>Armor</option>
                    <option value="consumable" {{ old('type') == 'consumable' ? 'selected' : '' }}>Consumable</option>
                </select>
            </div>

            <div>
                <label for="slot" class="mb-1 block text-sm font-medium text-slate-700">Slot</label>
                <select id="slot" name="slot" class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
                    <option value="nullable" {{ old('slot') == 'nullable' ? 'selected' : '' }}>Sin slot (nullable)</option>
                    <option value="head" {{ old('slot') == 'head' ? 'selected' : '' }}>Head</option>
                    <option value="body" {{ old('slot') == 'body' ? 'selected' : '' }}>Body</option>
                    <option value="weapon" {{ old('slot') == 'weapon' ? 'selected' : '' }}>Weapon</option>
                </select>
            </div>
        </div>

        <div>
            <label for="power" class="mb-1 block text-sm font-medium text-slate-700">Poder (0 - 30)</label>
            <input id="power" name="power" type="number" min="0" max="30" value="{{ old('power', 0) }}" required
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div>
            <label for="image" class="mb-1 block text-sm font-medium text-slate-700">Imagen del ítem</label>
            <input id="image" name="image" type="file" accept="image/*"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
                Guardar ítem
            </button>
            <a href="{{ route('items.index') }}" class="text-sm font-semibold text-slate-700 hover:underline">Cancelar</a>
        </div>
    </form>
@endsection
