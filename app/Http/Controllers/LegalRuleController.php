<?php

namespace App\Http\Controllers;

use App\Http\Resources\LegalRuleResource;
use App\Models\LegalRule;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LegalRuleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $rules = LegalRule::where('statut', 'active')->get();

        return LegalRuleResource::collection($rules);
    }

    public function show(int $id): LegalRuleResource
    {
        $rule = LegalRule::where('statut', 'active')->findOrFail($id);

        return new LegalRuleResource($rule);
    }
}
