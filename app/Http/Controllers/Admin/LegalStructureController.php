<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLegalStructureRequest;
use App\Http\Requests\Admin\UpdateLegalStructureRequest;
use App\Http\Resources\LegalStructureResource;
use App\Models\LegalStructure;
use Illuminate\Http\JsonResponse;

class LegalStructureController extends Controller
{
    public function store(StoreLegalStructureRequest $request): JsonResponse
    {
        $structure = LegalStructure::create($request->validated());

        return response()->json([
            'message' => 'Structure juridique créée avec succès.',
            'data' => new LegalStructureResource($structure),
        ], 201);
    }

    public function update(UpdateLegalStructureRequest $request, LegalStructure $legalStructure): JsonResponse
    {
        $legalStructure->update($request->validated());

        return response()->json([
            'message' => 'Structure juridique mise à jour avec succès.',
            'data' => new LegalStructureResource($legalStructure->fresh()),
        ]);
    }

    public function destroy(LegalStructure $legalStructure): JsonResponse
    {
        $legalStructure->delete();

        return response()->json([
            'message' => 'Structure juridique supprimée avec succès.',
        ]);
    }
}
