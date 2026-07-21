<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Roadmap;
use App\Policies\ProjectPolicy;
use App\Policies\RoadmapPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(Roadmap::class, RoadmapPolicy::class);
    }
}
