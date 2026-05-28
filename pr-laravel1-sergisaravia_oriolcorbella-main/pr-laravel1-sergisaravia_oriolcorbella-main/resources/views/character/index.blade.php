@extends('layouts.app')

@section('title', 'Listado de personajes')

@section('content')
    <p class="mb-4 text-sm font-medium text-slate-600">
        Bienvenido, {{ auth()->user()->name }}
    </p>

    <div class="mb-5 flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Listado de personajes</h1>
            <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-600">
                {{ $characters->count() }} total
            </span>

            <div class="mt-3 flex flex-wrap gap-2">
                <a href="{{ route('items.index') }}" class="rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                    Ver lista de items
                </a>

                @if (auth()->user()?->role === 'admin')
                    <a href="{{ route('user.index') }}" class="rounded-md bg-violet-600 px-3 py-2 text-sm font-semibold text-white hover:bg-violet-700">
                        Ver lista de usuarios
                    </a>
                @endif
            </div>
        </div>
        
        {{-- BOTÓN DE CREAR --}}
        <a href="{{ route('character.create') }}" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            + Nuevo Personaje
        </a>
    </div>

    <ul class="space-y-3">
        @forelse ($characters as $character)
            <li class="rounded-lg border border-slate-200 p-4 transition hover:border-blue-200 hover:bg-blue-50/40">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <a href="{{ route('character.show', $character) }}" class="text-lg font-semibold text-blue-700 hover:underline">
                            {{ $character->name }}
                        </a>
                        <p class="mt-1 text-sm text-slate-600">
                            <span class="font-medium">Nivel:</span> {{ $character->level }}
                            <span class="mx-2 text-slate-300">|</span>
                            <span class="font-medium">Vida:</span> 
                            <span class="text-rose-600 font-bold">{{ $character->health }} HP</span>
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('character.edit', $character) }}" class="rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">
                            Editar
                        </a>

                        <form action="{{ route('character.destroy', $character) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este personaje?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-md bg-rose-600 px-3 py-2 text-sm font-semibold text-white hover:bg-rose-700">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </li>
        @empty
            <li class="rounded-lg border border-dashed border-slate-300 p-6 text-center text-slate-500">No hay personajes creados.</li>
        @endforelse
    </ul>
@endsection