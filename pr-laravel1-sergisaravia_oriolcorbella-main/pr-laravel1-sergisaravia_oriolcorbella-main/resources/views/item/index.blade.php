@extends('layouts.app')

@section('title', 'Listado de ítems')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('character.index') }}" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Volver
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Catálogo de Ítems</h1>
        </div>
        <div class="flex items-center gap-4">
            <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-600">{{ $items->count() }} total</span>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('items.deleted') }}" class="rounded-md border border-rose-300 bg-rose-50 px-3 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-100">
                    Ver eliminados
                </a>
                <a href="{{ route('items.create') }}" class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                    Nuevo Ítem
                </a>
            @endif
        </div>
    </div>

    <ul class="space-y-3">
        @forelse ($items as $item)
            <li class="rounded-lg border border-slate-200 p-4 transition hover:border-blue-200 hover:bg-blue-50/40">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('items.show', $item) }}" class="text-lg font-semibold text-blue-700 hover:underline">
                                {{ $item->name }}
                            </a>
                            @if($item->trashed())
                                <span class="text-xs font-bold uppercase text-rose-500 bg-rose-50 px-2 py-0.5 rounded border border-rose-100">Eliminado (Soft Delete)</span>
                            @endif
                        </div>
                        <p class="mt-1 text-sm text-slate-600">
                            <span class="font-medium">Tipo:</span> {{ ucfirst($item->type) }}
                            <span class="mx-2 text-slate-300">|</span>
                            <span class="font-medium">Poder:</span>
                            <span class="text-amber-600 font-bold">{{ $item->power }} / 30</span>
                        </p>
                    </div>

                    @if(auth()->user()->role === 'admin')
                        <div class="flex gap-2">
                            <a href="{{ route('items.edit', $item) }}" class="rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200">
                                Editar
                            </a>
                            <form action="{{ route('items.destroy', $item) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este ítem?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-md bg-rose-600 px-3 py-2 text-sm font-semibold text-white hover:bg-rose-700">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </li>
        @empty
            <li class="rounded-lg border border-dashed border-slate-300 p-6 text-center text-slate-500">No hay ítems en el sistema.</li>
        @endforelse
    </ul>
@endsection
