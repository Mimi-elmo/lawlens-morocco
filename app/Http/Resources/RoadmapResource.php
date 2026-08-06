<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoadmapResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'forme_juridique_recommandee_id' => $this->forme_juridique_recommandee_id,
            'resume' => $this->resume,
            'statut' => $this->statut,
            'progression' => $this->progression,
            'date_generation' => $this->date_generation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'steps' => RoadmapStepResource::collection($this->whenLoaded('steps')),
            'documents' => RoadmapDocumentResource::collection($this->whenLoaded('documents')),
            'tax_obligations' => TaxObligationResource::collection($this->whenLoaded('taxObligations')),
        ];
    }
}
