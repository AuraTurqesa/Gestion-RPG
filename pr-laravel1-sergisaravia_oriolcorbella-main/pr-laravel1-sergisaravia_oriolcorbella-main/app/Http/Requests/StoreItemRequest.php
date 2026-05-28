<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'type'  => 'required|in:weapon,armor,consumable',
            'slot'  => 'required|in:head,body,weapon,nullable',
            'power' => 'required|integer|min:0|max:30',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del item es obligatorio.',
            'type.required' => 'Debes seleccionar un tipo.',
            'type.in' => 'El tipo seleccionado no es valido.',
            'slot.required' => 'Debes seleccionar un slot.',
            'slot.in' => 'El slot seleccionado no es valido.',
            'power.required' => 'El poder es obligatorio.',
            'power.integer' => 'El poder debe ser un numero entero.',
            'power.min' => 'El poder minimo es 0.',
            'power.max' => 'El poder maximo es 30.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo: jpg, jpeg, png, webp o gif.',
            'image.max' => 'La imagen no puede superar los 4MB.',
        ];
    }
}
