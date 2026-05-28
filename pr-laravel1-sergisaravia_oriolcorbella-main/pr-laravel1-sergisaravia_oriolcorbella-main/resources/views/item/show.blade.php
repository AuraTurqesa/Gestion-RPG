@extends('layouts.app')

@section('title', 'Detalle del ítem')

@section('content')
    <div class="mb-5 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">{{ $item->name }}</h1>
        <a href="{{ route('items.index') }}" class="text-sm font-semibold text-slate-700 hover:underline">Volver</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @if ($item->image_path)
            <div class="md:col-span-3">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="Imagen de {{ $item->name }}"
                    class="h-48 w-48 rounded-lg border border-slate-200 object-cover">
            </div>
        @endif

        <div class="rounded-lg bg-slate-50 p-4 border border-slate-200">
            <p class="text-xs text-slate-500 uppercase font-bold">Tipo</p>
            <p class="text-xl font-bold text-slate-900">{{ ucfirst($item->type) }}</p>
        </div>
        <div class="rounded-lg bg-blue-50 p-4 border border-blue-100">
            <p class="text-xs text-blue-500 uppercase font-bold">Slot</p>
            <p class="text-xl font-bold text-blue-900">{{ $item->slot === 'nullable' ? 'Ninguno' : ucfirst($item->slot) }}</p>
        </div>
        <div class="rounded-lg bg-amber-50 p-4 border border-amber-100">
            <p class="text-xs text-amber-600 uppercase font-bold">Poder</p>
            <p class="text-xl font-bold text-amber-900">{{ $item->power }} / 30</p>
        </div>
    </div>

    <div class="mt-8 flex gap-3">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('items.edit', $item) }}" class="rounded-md bg-slate-800 px-4 py-2 font-semibold text-white hover:bg-slate-900">
                Editar Ítem
            </a>

            @if($item->trashed())
                {{-- Si implementas el endpoint de restore del Bonus B --}}
                <form action="{{ route('items.restore', $item->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-md bg-emerald-600 px-4 py-2 font-semibold text-white hover:bg-emerald-700">
                        Restaurar
                    </button>
                </form>
            @else
                <form action="{{ route('items.destroy', $item) }}" method="POST" onsubmit="return confirm('¿Enviar este ítem a la papelera?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-md border border-rose-600 px-4 py-2 font-semibold text-rose-600 hover:bg-rose-50">
                        Eliminar
                    </button>
                </form>
            @endif
        @endif
    </div>
@endsection
