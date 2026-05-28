<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    /**
     * Muestra un formulario simple para subir imagen.
     */
    public function showForm()
    {
        return view('import.image_form');
    }

    /**
     * Sube una imagen desde el ordenador al disco public.
     */
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'folder' => ['nullable', 'string', 'max:50', 'regex:/^[a-z0-9_\-]+$/'],
        ]);

        $folder = $validated['folder'] ?? 'uploads';
        $path = $request->file('image')->store($folder, 'public');

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'message' => 'Imagen subida correctamente.',
                'path' => $path,
                'url' => asset('storage/' . $path),
            ], 201);
        }

        return back()->with('success', 'Imagen subida correctamente.')->with('uploaded_image_url', asset('storage/' . $path));
    }
}
