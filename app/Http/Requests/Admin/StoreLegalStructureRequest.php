<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLegalStructureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:legal_structures,slug'],
            'description' => ['nullable', 'string'],
            'capital_information' => ['nullable', 'string'],
            'tax_information' => ['nullable', 'string'],
            'statut' => ['sometimes', 'string', 'in:active,inactive'],
        ];
    }
}
