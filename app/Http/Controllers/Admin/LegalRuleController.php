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
    public function index(): AnonymousResourceCollection
    {
        return LegalRuleResource::collection(LegalRule::all());
    }

    public function store(StoreLegalRuleRequest $request): JsonResponse
    {
        $rule = LegalRule::create($request->validated());

        return response()->json([
            'legal_rule' => new LegalRuleResource($rule),
            'message' => 'Règle juridique créée avec succès.',
        ], 201);
    }

    public function show(int $id): LegalRuleResource
    {
        return new LegalRuleResource(LegalRule::findOrFail($id));
    }

    public function update(int $id, UpdateLegalRuleRequest $request): JsonResponse
    {
        $rule = LegalRule::findOrFail($id);
        $rule->update($request->validated());

        return response()->json([
            'legal_rule' => new LegalRuleResource($rule),
            'message' => 'Règle juridique mise à jour avec succès.',
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $rule = LegalRule::findOrFail($id);
        $rule->delete();

        return response()->json([
            'message' => 'Règle juridique supprimée avec succès.',
        ]);
    }
}
