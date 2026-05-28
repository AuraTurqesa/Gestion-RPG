@extends('layouts.app')

@section('title', 'Subir imagen')

@section('content')
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Subir imagen desde el ordenador</h1>

    @if (session('success'))
        <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label for="image" class="mb-1 block text-sm font-medium text-slate-700">Imagen</label>
            <input id="image" name="image" type="file" accept="image/*" required
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900">
        </div>

        <div>
            <label for="folder" class="mb-1 block text-sm font-medium text-slate-700">Carpeta (opcional)</label>
            <input id="folder" name="folder" type="text" value="{{ old('folder', 'uploads') }}"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900">
        </div>

        <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
            Subir imagen
        </button>
    </form>

    @if (session('uploaded_image_url'))
        <div class="mt-6">
            <p class="mb-2 text-sm font-medium text-slate-700">Vista previa:</p>
            <img src="{{ session('uploaded_image_url') }}" alt="Imagen subida" class="max-h-64 rounded-md border border-slate-200">
        </div>
    @endif
@endsection
