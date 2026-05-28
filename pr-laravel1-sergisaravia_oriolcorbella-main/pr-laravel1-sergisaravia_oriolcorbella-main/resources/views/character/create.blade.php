@extends('layouts.app')

@section('title', 'Crear personaje')

@section('content')
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Crear personaje</h1>

    <form action="{{ route('character.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nombre del Personaje</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="level" class="mb-1 block text-sm font-medium text-slate-700">Nivel</label>
                <input id="level" name="level" type="number" min="1" value="{{ old('level', 1) }}" required
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
            </div>

            <div>
                <label for="health" class="mb-1 block text-sm font-medium text-slate-700">Vida (Health)</label>
                <input id="health" name="health" type="number" min="1" value="{{ old('health', 100) }}" required
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
            </div>
        </div>

        <div>
            <label for="image" class="mb-1 block text-sm font-medium text-slate-700">Imagen del personaje</label>
            <input id="image" name="image" type="file" accept="image/*"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
                Guardar personaje
            </button>
            <a href="{{ route('character.index') }}" class="text-sm font-semibold text-slate-700 hover:underline">Cancelar</a>
        </div>
    </form>
@endsection