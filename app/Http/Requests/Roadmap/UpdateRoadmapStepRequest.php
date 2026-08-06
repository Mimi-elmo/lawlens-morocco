<?php

namespace App\Http\Requests\Roadmap;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoadmapStepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'statut' => ['required', 'string', 'in:pending,in_progress,completed'],
        ];
    }
}
