<?php

namespace App\Http\Requests\Web\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLegalStructureWebRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'capital_information' => ['nullable', 'string'],
            'tax_information' => ['nullable', 'string'],
            'statut' => ['sometimes', 'string', 'in:active,inactive'],
        ];
    }
}