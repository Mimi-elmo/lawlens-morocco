<?php

namespace App\Http\Resources;

use App\Models\LegalRule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin LegalRule */
class LegalRuleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'categorie' => $this->categorie,
            'source' => $this->source,
            'date_entree_vigueur' => $this->date_entree_vigueur,
        ];
    }
}
