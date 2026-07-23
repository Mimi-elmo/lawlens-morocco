<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'activite' => $this->activite,
            'description' => $this->description,
            'ville' => $this->ville,
            'budget' => $this->budget,
            'nombre_associes' => $this->nombre_associes,
            'type_activite' => $this->type_activite,
            'statut' => $this->statut,
            'roadmaps_count' => $this->whenCounted('roadmaps'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
