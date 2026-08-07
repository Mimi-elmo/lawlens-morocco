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
    /**
     * Liste des feuilles de route d'un projet
     *
     * @urlParam project integer required L'identifiant du projet.
     *
     * @response {
     *  "data": [
     *      {
     *          "id": 1,
     *          "project_id": 2,
     *          "forme_juridique_recommandee_id": 1,
     *          "resume": "…",
     *          "statut": "en_cours",
     *          "progression": 45,
     *          "date_generation": "2026-08-01T10:00:00.000000Z",
     *          "steps": [
     *              {"id": 1, "roadmap_id": 1, "titre": "Choisir la forme juridique", "ordre": 1, "statut": "completed"}
     *          ],
     *          "documents": [],
     *          "tax_obligations": []
     *      }
     *  ]
     * }
     */
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

    /**
     * Détail d'une feuille de route
     *
     * @response {
     *  "data": {
     *      "id": 1,
     *      "project_id": 2,
     *      "statut": "en_cours",
     *      "progression": 45
     *  }
     * }
     */
    public function show(Roadmap $roadmap): RoadmapResource
    {
        $this->authorize('view', $roadmap);

        $roadmap->load(['steps', 'documents', 'taxObligations']);

        return new RoadmapResource($roadmap);
    }

    /**
     * Générer une feuille de route (asynchrone)
     *
     * Lance le job de génération; la feuille de route est disponible via l'index du projet.
     *
     * @urlParam project integer required L'identifiant du projet.
     *
     * @response status=202 scenario="accepted" {
     *  "message": "Génération de la feuille de route lancée."
     * }
     */
    public function generate(int $projectId): JsonResponse
    {
        $project = Project::findOrFail($projectId);

        $this->authorize('view', $project);

        GenerateRoadmap::dispatch($project);

        return response()->json([
            'message' => 'Génération de la feuille de route lancée.',
        ], 202);
    }

    /**
     * Mettre à jour le statut d'une étape
     *
     * @response scenario="success" {
     *  "step": {
     *      "id": 1,
     *      "roadmap_id": 2,
     *      "titre": "Enregistrer la société",
     *      "ordre": 2,
     *      "statut": "completed"
     *  },
     *  "progression": 66,
     *  "message": "Statut de l'étape mis à jour."
     * }
     */
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
