@extends('layouts.app')

@section('title', 'Inventario y equipo')

@section('content')
    <div class="mb-5 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Inventario de {{ $character->name }}</h1>
            <p class="text-sm text-slate-500">Equipo actual y objetos en posesion</p>
        </div>
        <a href="{{ route('character.show', $character) }}" class="text-sm font-semibold text-slate-700 hover:underline">Volver</a>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        @php
            $head = $equipped['head'] ?? null;
            $body = $equipped['body'] ?? null;
            $weapon = $equipped['weapon'] ?? null;
        @endphp

        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs font-bold uppercase text-slate-500">Head</p>
            <p class="mt-2 text-sm font-semibold text-slate-800">{{ $head['name'] ?? 'Sin equipar' }}</p>
        </div>

        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs font-bold uppercase text-slate-500">Body</p>
            <p class="mt-2 text-sm font-semibold text-slate-800">{{ $body['name'] ?? 'Sin equipar' }}</p>
        </div>

        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs font-bold uppercase text-slate-500">Weapon</p>
            <p class="mt-2 text-sm font-semibold text-slate-800">{{ $weapon['name'] ?? 'Sin equipar' }}</p>
        </div>
    </div>

    @if ($errors->has('inventory'))
        <div class="mb-4 rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ $errors->first('inventory') }}
        </div>
    @endif

    <div class="mb-6 rounded-lg border border-slate-200 bg-white p-4">
        <h2 class="mb-4 font-semibold text-slate-900">Seleccionar equipo</h2>

        @php
            $allItems = collect($selectableItems);
            $headCurrent = $head['id'] ?? null;
            $bodyCurrent = $body['id'] ?? null;
            $weaponCurrent = $weapon['id'] ?? null;
        @endphp

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <form action="{{ route('character.inventory.update', $character) }}" method="POST">
                @csrf
                <label for="head_item_id" class="mb-1 block text-sm font-medium text-slate-700">Head</label>
                <select id="head_item_id" name="head_item_id" class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900">
                    <option value="">Sin equipar</option>
                    @foreach ($allItems as $item)
                        <option value="{{ $item['id'] }}" @selected($headCurrent === $item['id']) @disabled(!in_array($item['slot'], ['head']))>
                            {{ $item['name'] }} ({{ $item['type'] }} / {{ $item['slot'] }})
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="mt-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Guardar Head
                </button>
            </form>

            <form action="{{ route('character.inventory.update', $character) }}" method="POST">
                @csrf
                <label for="body_item_id" class="mb-1 block text-sm font-medium text-slate-700">Body</label>
                <select id="body_item_id" name="body_item_id" class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900">
                    <option value="">Sin equipar</option>
                    @foreach ($allItems as $item)
                        <option value="{{ $item['id'] }}" @selected($bodyCurrent === $item['id']) @disabled(!in_array($item['slot'], ['body']))>
                            {{ $item['name'] }} ({{ $item['type'] }} / {{ $item['slot'] }})
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="mt-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Guardar Body
                </button>
            </form>

            <form action="{{ route('character.inventory.update', $character) }}" method="POST">
                @csrf
                <label for="weapon_item_id" class="mb-1 block text-sm font-medium text-slate-700">Weapon</label>
                <select id="weapon_item_id" name="weapon_item_id" class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900">
                    <option value="">Sin equipar</option>
                    @foreach ($allItems as $item)
                        <option value="{{ $item['id'] }}" @selected($weaponCurrent === $item['id']) @disabled(!in_array($item['slot'], ['weapon']))>
                            {{ $item['name'] }} ({{ $item['type'] }} / {{ $item['slot'] }})
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="mt-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Guardar Weapon
                </button>
            </form>
        </div>
    </div>

    <div class="rounded-lg border border-slate-200 bg-white">
        <div class="border-b border-slate-200 px-4 py-3">
            <h2 class="font-semibold text-slate-900">Objetos en inventario</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Nombre</th>
                        <th class="px-4 py-3 font-semibold">Tipo</th>
                        <th class="px-4 py-3 font-semibold">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($items as $item)
                        <tr>
                            <td class="px-4 py-3 text-slate-900">{{ $item['name'] }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item['type'] }}</td>
                            <td class="px-4 py-3">
                                @if ($item['is_equipped'])
                                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">
                                        Equipped
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">
                                        In bag
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-5 text-center text-slate-500">No hay objetos en inventario.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
