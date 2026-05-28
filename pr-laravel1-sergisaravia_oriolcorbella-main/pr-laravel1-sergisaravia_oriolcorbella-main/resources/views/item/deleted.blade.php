@extends('layouts.app')

@section('title', 'Items eliminados')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('items.index') }}" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Volver a items
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Items eliminados</h1>
        </div>
        <span class="rounded-full bg-rose-100 px-3 py-1 text-sm font-medium text-rose-700">{{ $items->count() }} eliminados</span>
    </div>

    <ul class="space-y-3">
        @forelse ($items as $item)
            <li class="rounded-lg border border-rose-200 bg-rose-50/40 p-4">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="text-lg font-semibold text-slate-900">{{ $item->name }}</p>
                        <p class="mt-1 text-sm text-slate-600">
                            <span class="font-medium">Tipo:</span> {{ ucfirst($item->type) }}
                            <span class="mx-2 text-slate-300">|</span>
                            <span class="font-medium">Poder:</span>
                            <span class="text-amber-600 font-bold">{{ $item->power }} / 30</span>
                        </p>
                    </div>

                    <form action="{{ route('items.restore', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                            Restaurar
                        </button>
                    </form>
                </div>
            </li>
        @empty
            <li class="rounded-lg border border-dashed border-slate-300 p-6 text-center text-slate-500">
                No hay items eliminados.
            </li>
        @endforelse
    </ul>
@endsection
