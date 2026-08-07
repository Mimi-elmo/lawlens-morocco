<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Roadmap;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Statistiques du tableau de bord entrepreneur
     *
     * @response scenario="success" {
     *  "projects_count": 3,
     *  "projects_by_status": {"en_cours": 2, "termine": 1},
     *  "roadmaps_count": 2,
     *  "roadmaps_by_status": {"en_cours": 1, "complete": 1},
     *  "global_progression": 45,
     *  "recent_roadmaps": [
     *      {"id": 1, "project_id": 2, "statut": "en_cours", "progression": 50, "date_generation": "2026-08-01T10:00:00.000000Z"}
     *  ]
     * }
     */
    public function entrepreneur(Request $request): JsonResponse
    {
        $user = $request->user();

        $projects = Project::where('user_id', $user->id);
        $roadmaps = Roadmap::whereIn('project_id', Project::where('user_id', $user->id)->select('id'));

        $projectsCount = (clone $projects)->count();
        $projectsByStatus = (clone $projects)->selectRaw('statut, count(*) as total')->groupBy('statut')->pluck('total', 'statut');

        $roadmapsCount = (clone $roadmaps)->count();
        $roadmapsByStatus = (clone $roadmaps)->selectRaw('statut, count(*) as total')->groupBy('statut')->pluck('total', 'statut');

        $globalProgression = (clone $roadmaps)->avg('progression');

        $recentRoadmaps = (clone $roadmaps)->with('project:id,nom')
            ->latest()
            ->take(5)
            ->get(['id', 'project_id', 'statut', 'progression', 'date_generation']);

        return response()->json([
            'projects_count' => $projectsCount,
            'projects_by_status' => $projectsByStatus,
            'roadmaps_count' => $roadmapsCount,
            'roadmaps_by_status' => $roadmapsByStatus,
            'global_progression' => round($globalProgression ?? 0),
            'recent_roadmaps' => $recentRoadmaps,
        ]);
    }

    /**
     * Statistiques du tableau de bord administrateur
     *
     * @response scenario="success" {
     *  "total_users": 12,
     *  "users_by_role": {"entrepreneur": 10, "admin": 2},
     *  "total_projects": 25,
     *  "projects_by_status": {"en_cours": 15, "termine": 10},
     *  "total_roadmaps": 20,
     *  "roadmaps_by_status": {"en_cours": 12, "complete": 8},
     *  "recent_users": [
     *      {"id": 1, "name": "Yasmine Alaoui", "email": "yasmine@example.com", "role": "entrepreneur", "created_at": "2026-08-01T10:00:00.000000Z"}
     *  ]
     * }
     */
    public function admin(): JsonResponse
    {
        $totalUsers = User::count();
        $usersByRole = User::selectRaw('role, count(*) as total')->groupBy('role')->pluck('total', 'role');

        $totalProjects = Project::count();
        $projectsByStatus = Project::selectRaw('statut, count(*) as total')->groupBy('statut')->pluck('total', 'statut');

        $totalRoadmaps = Roadmap::count();
        $roadmapsByStatus = Roadmap::selectRaw('statut, count(*) as total')->groupBy('statut')->pluck('total', 'statut');

        $recentUsers = User::latest()->take(10)->get(['id', 'name', 'email', 'role', 'created_at']);

        return response()->json([
            'total_users' => $totalUsers,
            'users_by_role' => $usersByRole,
            'total_projects' => $totalProjects,
            'projects_by_status' => $projectsByStatus,
            'total_roadmaps' => $totalRoadmaps,
            'roadmaps_by_status' => $roadmapsByStatus,
            'recent_users' => $recentUsers,
        ]);
    }
}
