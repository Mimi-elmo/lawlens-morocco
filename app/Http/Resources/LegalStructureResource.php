<?php

namespace App\Http\Resources;

use App\Models\LegalStructure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin LegalStructure */
class LegalStructureResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'slug' => $this->slug,
            'description' => $this->description,
            'capital_information' => $this->capital_information,
            'tax_information' => $this->tax_information,
        ];
    }
}
