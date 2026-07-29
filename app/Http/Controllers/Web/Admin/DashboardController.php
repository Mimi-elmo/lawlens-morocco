<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Roadmap;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $usersByRole = User::selectRaw('role, count(*) as total')->groupBy('role')->pluck('total', 'role');

        $totalProjects = Project::count();
        $projectsByStatus = Project::selectRaw('statut, count(*) as total')->groupBy('statut')->pluck('total', 'statut');

        $totalRoadmaps = Roadmap::count();
        $roadmapsByStatus = Roadmap::selectRaw('statut, count(*) as total')->groupBy('statut')->pluck('total', 'statut');

        $globalProgression = round(Roadmap::avg('progression') ?? 0);

        $recentUsers = User::latest()->take(10)->get(['id', 'name', 'email', 'role', 'created_at']);

        return view('admin.dashboard', compact(
            'totalUsers', 'usersByRole',
            'totalProjects', 'projectsByStatus',
            'totalRoadmaps', 'roadmapsByStatus',
            'globalProgression',
            'recentUsers'
        ));
    }
}
