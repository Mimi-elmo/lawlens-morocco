<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLegalRuleRequest;
use App\Http\Requests\Admin\UpdateLegalRuleRequest;
use App\Http\Resources\LegalRuleResource;
use App\Models\LegalRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LegalRuleController extends Controller
{
    /**
     * Liste de toutes les règles juridiques
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
        return LegalRuleResource::collection(LegalRule::all());
    }

    /**
     * Créer une règle juridique
     *
     * @response status=201 scenario="success" {
     *  "legal_rule": {
     *      "id": 1,
     *      "titre": "Déclaration de cessation d'activité",
     *      "categorie": "fiscal"
     *  },
     *  "message": "Règle juridique créée avec succès."
     * }
     */
    public function store(StoreLegalRuleRequest $request): JsonResponse
    {
        $rule = LegalRule::create($request->validated());

        return response()->json([
            'legal_rule' => new LegalRuleResource($rule),
            'message' => 'Règle juridique créée avec succès.',
        ], 201);
    }

    /**
     * Détail d'une règle juridique
     *
     * @response {
     *  "data": {
     *      "id": 1,
     *      "titre": "Déclaration de cessation d'activité",
     *      "categorie": "fiscal"
     *  }
     * }
     */
    public function show(int $id): LegalRuleResource
    {
        return new LegalRuleResource(LegalRule::findOrFail($id));
    }

    /**
     * Mettre à jour une règle juridique
     *
     * @response scenario="success" {
     *  "legal_rule": {
     *      "id": 1,
     *      "titre": "Déclaration de cessation d'activité",
     *      "categorie": "fiscal"
     *  },
     *  "message": "Règle juridique mise à jour avec succès."
     * }
     */
    public function update(int $id, UpdateLegalRuleRequest $request): JsonResponse
    {
        $rule = LegalRule::findOrFail($id);
        $rule->update($request->validated());

        return response()->json([
            'legal_rule' => new LegalRuleResource($rule),
            'message' => 'Règle juridique mise à jour avec succès.',
        ]);
    }

    /**
     * Supprimer une règle juridique
     *
     * @response {
     *  "message": "Règle juridique supprimée avec succès."
     * }
     */
    public function destroy(int $id): JsonResponse
    {
        $rule = LegalRule::findOrFail($id);
        $rule->delete();

        return response()->json([
            'message' => 'Règle juridique supprimée avec succès.',
        ]);
    }
}
