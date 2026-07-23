<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Roadmap;
use App\Policies\ProjectPolicy;
use App\Policies\RoadmapPolicy;
use Illuminate\Http\Resources\Json\JsonResource;
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
        JsonResource::withoutWrapping();

        Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(Roadmap::class, RoadmapPolicy::class);
    }
}
