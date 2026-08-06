<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roadmap\UpdateRoadmapStepRequest;
use App\Http\Resources\RoadmapResource;
use App\Http\Resources\RoadmapStepResource;
use App\Jobs\GenerateRoadmap;
use App\Models\Project;
use App\Models\Roadmap;
use App\Models\RoadmapStep;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoadmapController extends Controller
{
    public function index(int $projectId): AnonymousResourceCollection
    {
        $project = Project::findOrFail($projectId);

        $this->authorize('view', $project);

        $roadmaps = $project->roadmaps()
            ->with(['steps', 'documents', 'taxObligations'])
            ->latest()
            ->get();

        return RoadmapResource::collection($roadmaps);
    }

    public function show(Roadmap $roadmap): RoadmapResource
    {
        $this->authorize('view', $roadmap);

        $roadmap->load(['steps', 'documents', 'taxObligations']);

        return new RoadmapResource($roadmap);
    }

    public function generate(int $projectId): JsonResponse
    {
        $project = Project::findOrFail($projectId);

        $this->authorize('view', $project);

        GenerateRoadmap::dispatch($project);

        return response()->json([
            'message' => 'Génération de la feuille de route lancée.',
        ], 202);
    }

    public function updateStep(RoadmapStep $step, UpdateRoadmapStepRequest $request): JsonResponse
    {
        $this->authorize('view', $step->roadmap);

        $step->update(['statut' => $request->statut]);

        $roadmap = $step->roadmap;
        $totalSteps = $roadmap->steps()->count();
        $completedSteps = $roadmap->steps()->where('statut', 'completed')->count();
        $progression = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;

        $roadmap->update(['progression' => $progression]);

        return response()->json([
            'step' => new RoadmapStepResource($step->fresh()),
            'progression' => $progression,
            'message' => 'Statut de l\'étape mis à jour.',
        ]);
    }
}
