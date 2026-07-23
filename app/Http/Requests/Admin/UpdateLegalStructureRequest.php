<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLegalStructureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['sometimes', 'string', 'max:255'],
            'slug' => ['sometimes', 'string', 'max:255', Rule::unique('legal_structures', 'slug')->ignore($this->route('legalStructure'))],
            'description' => ['nullable', 'string'],
            'capital_information' => ['nullable', 'string'],
            'tax_information' => ['nullable', 'string'],
            'statut' => ['sometimes', 'string', 'in:active,inactive'],
        ];
    }
}
