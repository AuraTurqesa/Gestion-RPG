@extends('layouts.app')

@section('title', 'Listado de usuarios')

@section('content')
    <div class="mb-5 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Listado de usuarios</h1>
            <p class="text-sm text-slate-500">{{ $users->count() }} usuarios registrados</p>
        </div>
        <a href="{{ route('character.index') }}" class="text-sm font-semibold text-slate-700 hover:underline">Volver a personajes</a>
    </div>

    <div class="rounded-lg border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 font-semibold">ID</th>
                        <th class="px-4 py-3 font-semibold">Nombre</th>
                        <th class="px-4 py-3 font-semibold">Email</th>
                        <th class="px-4 py-3 font-semibold">Rol</th>
                        <th class="px-4 py-3 font-semibold">Personajes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $user->id }}</td>
                            <td class="px-4 py-3 text-slate-900">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $user->role }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $user->characters_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-5 text-center text-slate-500">No hay usuarios.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
