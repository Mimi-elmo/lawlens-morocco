<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLegalRuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('legal_rule');

        return [
            'titre' => ['sometimes', 'string', 'max:255', Rule::unique('legal_rules', 'titre')->ignore($id)],
            'description' => ['nullable', 'string'],
            'categorie' => ['sometimes', 'string', 'in:legal,administrative,fiscal,document'],
            'source' => ['nullable', 'string', 'max:255'],
            'date_entree_vigueur' => ['nullable', 'date'],
            'statut' => ['sometimes', 'string', 'in:active,inactive'],
        ];
    }
}
