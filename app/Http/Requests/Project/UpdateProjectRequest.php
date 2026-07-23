<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['sometimes', 'string', 'max:255'],
            'activite' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'ville' => ['sometimes', 'string', 'max:255'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'nombre_associes' => ['sometimes', 'integer', 'min:1'],
            'type_activite' => ['sometimes', 'string', 'in:individuelle,societe'],
            'statut' => ['sometimes', 'string', 'in:brouillon,en_cours,termine'],
        ];
    }
}
