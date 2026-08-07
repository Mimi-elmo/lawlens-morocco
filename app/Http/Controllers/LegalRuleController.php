<?php

namespace App\Http\Controllers;

use App\Http\Resources\LegalRuleResource;
use App\Models\LegalRule;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LegalRuleController extends Controller
{
    /**
     * Liste des règles juridiques actives
     *
     * @unauthenticated
     *
     * @response {
     *  "data": [
     *      {
     *          "id": 1,
     *          "titre": "Déclaration de cessation d'activité",
     *          "description": "…",
     *          "categorie": "fiscal",
     *          "source": "DGI",
     *          "date_entree_vigueur": "2024-01-01"
     *      }
     *  ]
     * }
     */
    public function index(): AnonymousResourceCollection
    {
        $rules = LegalRule::where('statut', 'active')->get();

        return LegalRuleResource::collection($rules);
    }

    /**
     * Détail d'une règle juridique
     *
     * @unauthenticated
     *
     * @response {
     *  "data": {
     *      "id": 1,
     *      "titre": "Déclaration de cessation d'activité",
     *      "description": "…",
     *      "categorie": "fiscal",
     *      "source": "DGI",
     *      "date_entree_vigueur": "2024-01-01"
     *  }
     * }
     */
    public function show(int $id): LegalRuleResource
    {
        $rule = LegalRule::where('statut', 'active')->findOrFail($id);

        return new LegalRuleResource($rule);
    }
}
