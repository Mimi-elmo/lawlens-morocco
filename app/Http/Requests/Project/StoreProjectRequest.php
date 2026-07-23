<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'activite' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'ville' => ['required', 'string', 'max:255'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'nombre_associes' => ['required', 'integer', 'min:1'],
            'type_activite' => ['required', 'string', 'in:individuelle,societe'],
            'statut' => ['sometimes', 'string', 'in:brouillon,en_cours,termine'],
        ];
    }
}
