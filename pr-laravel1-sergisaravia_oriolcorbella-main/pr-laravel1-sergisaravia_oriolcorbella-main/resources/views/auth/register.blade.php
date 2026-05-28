@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-sm border border-slate-200">
    <h1 class="text-2xl font-bold text-slate-900 mb-6 text-center">Registro de Jugador</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring @error('name') border-rose-500 @enderror">
            @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring @error('email') border-rose-500 @enderror">
            @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Contraseña</label>
            <input id="password" name="password" type="password" required
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring @error('password') border-rose-500 @enderror">
            @error('password') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">Confirmar Contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-slate-600 hover:text-slate-900 underline" href="{{ route('login') }}">
                ¿Ya tienes cuenta?
            </a>

            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
                Registrarse
            </button>
        </div>
    </form>
</div>
@endsection