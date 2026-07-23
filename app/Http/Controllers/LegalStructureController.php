<?php

namespace App\Http\Controllers;

use App\Http\Resources\LegalStructureResource;
use App\Models\LegalStructure;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LegalStructureController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $structures = LegalStructure::where('statut', 'active')->get();

        return LegalStructureResource::collection($structures);
    }

    public function show(int $id): LegalStructureResource
    {
        $structure = LegalStructure::where('statut', 'active')->findOrFail($id);

        return new LegalStructureResource($structure);
    }
}
