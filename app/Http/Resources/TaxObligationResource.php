<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaxObligationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'roadmap_id' => $this->roadmap_id,
            'nom' => $this->nom,
            'description' => $this->description,
            'frequence' => $this->frequence,
            'obligatoire' => $this->obligatoire,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
