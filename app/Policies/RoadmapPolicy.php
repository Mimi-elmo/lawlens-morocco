<?php

namespace App\Policies;

use App\Models\Roadmap;
use App\Models\User;

class RoadmapPolicy
{
    public function view(User $user, Roadmap $roadmap): bool
    {
        return $user->id === $roadmap->project->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }
}
