@extends('layouts.app')

@section('title', 'Detalle del personaje')

@section('content')
    <div class="mb-5 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">{{ $character->name }}</h1>
        <a href="{{ route('character.index') }}" class="text-sm font-semibold text-slate-700 hover:underline">Volver</a>
    </div>

    <p class="text-lg text-slate-600 mt-1">Personaje de <span class="font-bold text-slate-800">{{ $character->user->name ?? 'Sistema' }}</span></p>

    @if ($character->image_path)
        <div class="mt-4">
            <img src="{{ asset('storage/' . $character->image_path) }}" alt="Imagen de {{ $character->name }}"
                class="h-48 w-48 rounded-lg border border-slate-200 object-cover">
        </div>
    @endif
    
    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="rounded-lg bg-blue-50 p-4 border border-blue-100">
            <p class="text-xs text-blue-500 uppercase font-bold">Nivel Actual</p>
            <p class="text-xl font-bold text-blue-900">{{ $character->level }}</p>
        </div>
        <div class="rounded-lg bg-rose-50 p-4 border border-rose-100">
            <p class="text-xs text-rose-500 uppercase font-bold">Puntos de Vida</p>
            <p class="text-xl font-bold text-rose-900">{{ $character->health }} HP</p>
        </div>
        <div class="rounded-lg bg-slate-50 p-4 border border-slate-100">
            <p class="text-xs text-slate-500 uppercase font-bold">Fecha de Creación</p>
            <p class="text-sm font-semibold">{{ $character->created_at->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="mt-8 flex gap-3">
        <a href="{{ route('character.inventory', $character) }}" class="rounded-md bg-blue-600 px-4 py-2 font-semibold text-white shadow-sm hover:bg-blue-700">
            Ver inventory
        </a>

        <a href="{{ route('items.index') }}" class="rounded-md bg-emerald-600 px-4 py-2 font-semibold text-white hover:bg-emerald-700">
            Ver lista de items
        </a>

        <a href="{{ route('character.edit', $character) }}" class="rounded-md bg-slate-800 px-4 py-2 font-semibold text-white hover:bg-slate-900">
            Editar Personaje
        </a>
        <form action="{{ route('character.destroy', $character) }}" method="POST" onsubmit="return confirm('¿Eliminar este personaje permanentemente?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-md border border-rose-600 px-4 py-2 font-semibold text-rose-600 hover:bg-rose-50">
                Eliminar
            </button>
        </form>
    </div>
@endsection