@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-sm border border-slate-200">
    <h1 class="text-2xl font-bold text-slate-900 mb-6 text-center">Identificación</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring @error('email') border-rose-500 @enderror">
            @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Contraseña</label>
            <input id="password" name="password" type="password" required
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 outline-none ring-blue-500 focus:ring">
        </div>

        <div class="flex items-center">
            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 border-slate-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-slate-700">Recordarme</label>
        </div>

        <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
            Entrar
        </button>

        <p class="text-center text-sm text-slate-600 mt-4">
            ¿No eres miembro? <a href="{{ route('register') }}" class="text-blue-700 font-semibold hover:underline">Crea una cuenta</a>
        </p>
    </form>
</div>
@endsection