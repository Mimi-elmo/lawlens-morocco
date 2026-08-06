<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Jobs\GenerateRoadmapJob;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $projects = Project::where('user_id', auth()->id())
            ->withCount('roadmaps')
            ->latest()
            ->get();

        return ProjectResource::collection($projects);
    }

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

    public function show(int $id): ProjectResource
    {
        $project = Project::withCount('roadmaps')->findOrFail($id);

        $this->authorize('view', $project);

        return new ProjectResource($project);
    }

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

    public function destroy(int $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        $this->authorize('delete', $project);

        $project->delete();

        return response()->json([
            'message' => 'Projet supprimé avec succès.',
        ]);
    }

    public function generateRoadmap(int $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        $this->authorize('update', $project);

        if ($project->roadmaps()->whereIn('statut', ['pending', 'generating'])->exists()) {
            return response()->json([
                'message' => 'Un roadmap est déjà en cours de génération pour ce projet.',
            ], 409);
        }

        $project->roadmaps()->create([
            'statut' => 'pending',
            'date_generation' => now(),
        ]);

        GenerateRoadmapJob::dispatch($project);

        return response()->json([
            'message' => 'Génération du roadmap lancée.',
            'project_id' => $project->id,
        ], 202);
    }
}
