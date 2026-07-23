<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLegalRuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', 'max:255', 'unique:legal_rules,titre'],
            'description' => ['nullable', 'string'],
            'categorie' => ['required', 'string', 'in:legal,administrative,fiscal,document'],
            'source' => ['nullable', 'string', 'max:255'],
            'date_entree_vigueur' => ['nullable', 'date'],
            'statut' => ['sometimes', 'string', 'in:active,inactive'],
        ];
    }
}
