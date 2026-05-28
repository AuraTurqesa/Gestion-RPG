<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCharacterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|min:3|max:50',
            'level' => 'sometimes|integer|min:1|max:100',
            'health' => 'sometimes|integer|min:1|max:200',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ];
    }
}
