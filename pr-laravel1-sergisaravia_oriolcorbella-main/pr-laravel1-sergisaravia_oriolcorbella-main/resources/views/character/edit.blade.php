@extends('layouts.app')

@section('title', 'Editar personaje')

@section('content')
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Editar personaje</h1>

    <form action="{{ route('character.update', $character) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name', $character->name) }}" required
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="level" class="mb-1 block text-sm font-medium text-slate-700">Nivel</label>
                <input id="level" name="level" type="number" min="1" value="{{ old('level', $character->level) }}" required
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
            </div>

            <div>
                <label for="health" class="mb-1 block text-sm font-medium text-slate-700">Vida</label>
                <input id="health" name="health" type="number" min="1" value="{{ old('health', $character->health) }}" required
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
            </div>
        </div>

        @if ($character->image_path)
            <div>
                <p class="mb-2 text-sm font-medium text-slate-700">Imagen actual</p>
                <img src="{{ asset('storage/' . $character->image_path) }}" alt="Imagen de {{ $character->name }}"
                    class="h-32 w-32 rounded-lg border border-slate-200 object-cover">
            </div>
        @endif

        <div>
            <label for="image" class="mb-1 block text-sm font-medium text-slate-700">Nueva imagen (opcional)</label>
            <input id="image" name="image" type="file" accept="image/*"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
                Actualizar personaje
            </button>
            <a href="{{ route('character.show', $character) }}" class="text-sm font-semibold text-slate-700 hover:underline">Cancelar</a>
        </div>
    </form>
@endsection