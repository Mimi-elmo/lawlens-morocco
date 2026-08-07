<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    /**
     * Liste des projets de l'utilisateur connecté
     *
     * @response {
     *  "data": [
     *      {
     *          "id": 1,
     *          "nom": "Boulangerie Amal",
     *          "activite": "Artisanat alimentaire",
     *          "description": "…",
     *          "ville": "Casablanca",
     *          "budget": 200000,
     *          "nombre_associes": 2,
     *          "type_activite": "commerce",
     *          "statut": "en_creation",
     *          "roadmaps_count": 1,
     *          "created_at": "2026-08-01T10:00:00.000000Z",
     *          "updated_at": "2026-08-01T10:00:00.000000Z"
     *      }
     *  ]
     * }
     */
    public function index(): AnonymousResourceCollection
    {
        $projects = Project::where('user_id', auth()->id())
            ->withCount('roadmaps')
            ->latest()
            ->get();

        return ProjectResource::collection($projects);
    }

    /**
     * Créer un projet
     *
     * @response status=201 scenario="success" {
     *  "project": {
     *      "id": 1,
     *      "nom": "Boulangerie Amal",
     *      "activite": "Artisanat alimentaire",
     *      "statut": "en_creation"
     *  },
     *  "message": "Projet créé avec succès."
     * }
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = Project::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'project' => new ProjectResource($project),
            'message' => 'Projet créé avec succès.',
        ], 201);
    }

    /**
     * Détail d'un projet
     *
     * @response {
     *  "data": {
     *      "id": 1,
     *      "nom": "Boulangerie Amal",
     *      "roadmaps_count": 1
     *  }
     * }
     */
    public function show(int $id): ProjectResource
    {
        $project = Project::withCount('roadmaps')->findOrFail($id);

        $this->authorize('view', $project);

        return new ProjectResource($project);
    }

    /**
     * Mettre à jour un projet
     *
     * @response scenario="success" {
     *  "project": {
     *      "id": 1,
     *      "nom": "Boulangerie Amal",
     *      "statut": "en_creation"
     *  },
     *  "message": "Projet mis à jour avec succès."
     * }
     */
    public function update(int $id, UpdateProjectRequest $request): JsonResponse
    {
        $project = Project::findOrFail($id);

        $this->authorize('update', $project);

        $project->update($request->validated());

        return response()->json([
            'project' => new ProjectResource($project->loadCount('roadmaps')),
            'message' => 'Projet mis à jour avec succès.',
        ]);
    }

    /**
     * Supprimer un projet
     *
     * @response {
     *  "message": "Projet supprimé avec succès."
     * }
     */
    public function destroy(int $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        $this->authorize('delete', $project);

        $project->delete();

        return response()->json([
            'message' => 'Projet supprimé avec succès.',
        ]);
    }
}
