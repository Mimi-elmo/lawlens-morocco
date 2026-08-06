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
            'forme_juridique_recommandee' => $this->whenLoaded('formeJuridiqueRecommendee', fn () => [
                'id' => $this->formeJuridiqueRecommendee->id,
                'nom' => $this->formeJuridiqueRecommendee->nom,
                'slug' => $this->formeJuridiqueRecommendee->slug,
            ]),
            'resume' => $this->resume,
            'statut' => $this->statut,
            'progression' => $this->progression,
            'completed_steps' => $this->whenAggregated('steps', 'statut', 'count', 'completed'),
            'total_steps' => $this->whenCounted('steps'),
            'steps' => $this->whenLoaded('steps', fn () => $this->steps->map(fn ($s) => [
                'id' => $s->id,
                'titre' => $s->titre,
                'description' => $s->description,
                'ordre' => $s->ordre,
                'statut' => $s->statut,
            ])),
            'documents' => $this->whenLoaded('documents', fn () => $this->documents->map(fn ($d) => [
                'id' => $d->id,
                'nom' => $d->nom,
                'description' => $d->description,
                'obligatoire' => $d->obligatoire,
                'statut' => $d->statut,
            ])),
            'tax_obligations' => $this->whenLoaded('taxObligations', fn () => $this->taxObligations->map(fn ($t) => [
                'id' => $t->id,
                'nom' => $t->nom,
                'description' => $t->description,
                'frequence' => $t->frequence,
                'obligatoire' => $t->obligatoire,
            ])),
            'date_generation' => $this->date_generation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
