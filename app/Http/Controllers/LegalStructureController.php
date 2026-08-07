<?php

namespace App\Http\Controllers;

use App\Http\Resources\LegalStructureResource;
use App\Models\LegalStructure;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LegalStructureController extends Controller
{
    /**
     * Liste des structures juridiques actives
     *
     * @unauthenticated
     *
     * @response {
     *  "data": [
     *      {
     *          "id": 1,
     *          "nom": "SARL",
     *          "slug": "sarl",
     *          "description": "Société à responsabilité limitée",
     *          "capital_information": "…",
     *          "tax_information": "…"
     *      }
     *  ]
     * }
     */
    public function index(): AnonymousResourceCollection
    {
        $structures = LegalStructure::where('statut', 'active')->get();

        return LegalStructureResource::collection($structures);
    }

    /**
     * Détail d'une structure juridique
     *
     * @unauthenticated
     *
     * @response {
     *  "data": {
     *      "id": 1,
     *      "nom": "SARL",
     *      "slug": "sarl",
     *      "description": "Société à responsabilité limitée",
     *      "capital_information": "…",
     *      "tax_information": "…"
     *  }
     * }
     */
    public function show(int $id): LegalStructureResource
    {
        $structure = LegalStructure::where('statut', 'active')->findOrFail($id);

        return new LegalStructureResource($structure);
    }
}
