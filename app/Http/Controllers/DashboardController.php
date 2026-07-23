<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Roadmap;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
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
