<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Roadmap;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $projects = Project::where('user_id', $user->id);
        $roadmaps = Roadmap::whereIn('project_id', Project::where('user_id', $user->id)->select('id'));

        $projectsCount = (clone $projects)->count();
        $projectsByStatus = (clone $projects)->selectRaw('statut, count(*) as total')->groupBy('statut')->pluck('total', 'statut');

        $roadmapsCount = (clone $roadmaps)->count();
        $roadmapsByStatus = (clone $roadmaps)->selectRaw('statut, count(*) as total')->groupBy('statut')->pluck('total', 'statut');

        $globalProgression = round((clone $roadmaps)->avg('progression') ?? 0);

        $recentProjects = (clone $projects)->latest()->take(5)->get();
        $recentRoadmaps = (clone $roadmaps)->with('project:id,nom')->latest()->take(5)->get(['id', 'project_id', 'statut', 'progression', 'date_generation']);

        return view('dashboard', compact(
            'projectsCount', 'projectsByStatus',
            'roadmapsCount', 'roadmapsByStatus',
            'globalProgression',
            'recentProjects', 'recentRoadmaps'
        ));
    }
}
