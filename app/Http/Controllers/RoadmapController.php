<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoadmapResource;
use App\Models\Project;
use App\Models\Roadmap;
use App\Models\RoadmapStep;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoadmapController extends Controller
{
    public function index(Project $project): AnonymousResourceCollection
    {
        $this->authorize('view', $project);

        $roadmaps = $project->roadmaps()
            ->withCount(['steps', 'steps as completed_steps' => fn ($q) => $q->where('statut', 'completed')])
            ->latest()
            ->get();

        return RoadmapResource::collection($roadmaps);
    }

    public function show(Roadmap $roadmap): RoadmapResource
    {
        $this->authorize('view', $roadmap->project);

        $roadmap->load(['steps' => fn ($q) => $q->orderBy('ordre'), 'documents', 'taxObligations', 'formeJuridiqueRecommendee']);

        return new RoadmapResource($roadmap);
    }

    public function updateStep(Roadmap $roadmap, RoadmapStep $step): JsonResponse
    {
        $this->authorize('update', $roadmap->project);

        if ($step->roadmap_id !== $roadmap->id) {
            return response()->json(['message' => 'Cette étape n\'appartient pas à ce roadmap.'], 400);
        }

        $allowed = [
            'pending' => 'in_progress',
            'in_progress' => 'completed',
        ];

        $next = $allowed[$step->statut] ?? null;

        if (! $next) {
            return response()->json([
                'message' => 'Transition de statut non autorisée.',
                'current' => $step->statut,
                'allowed_transitions' => array_keys($allowed),
            ], 400);
        }

        $step->update(['statut' => $next]);
        $roadmap->updateProgress();

        return response()->json([
            'message' => 'Statut mis à jour.',
            'step' => $step->fresh(),
            'progression' => $roadmap->fresh()->progression,
        ]);
    }
}
