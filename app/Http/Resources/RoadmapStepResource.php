<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoadmapStepResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'roadmap_id' => $this->roadmap_id,
            'titre' => $this->titre,
            'description' => $this->description,
            'ordre' => $this->ordre,
            'statut' => $this->statut,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
