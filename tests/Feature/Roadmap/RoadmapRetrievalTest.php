<?php

use App\Models\Project;
use App\Models\Roadmap;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('lists roadmaps for a project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    Roadmap::factory()->count(2)->for($project)->create();

    $response = $this->actingAs($user)->getJson("/api/projects/{$project->id}/roadmaps");

    $response->assertStatus(200)
        ->assertJsonCount(2);
});

it('returns empty list when project has no roadmaps', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();

    $response = $this->actingAs($user)->getJson("/api/projects/{$project->id}/roadmaps");

    $response->assertStatus(200)
        ->assertJsonCount(0);
});

it('denies listing roadmaps for another user project', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();

    $response = $this->actingAs($other)->getJson("/api/projects/{$project->id}/roadmaps");

    $response->assertStatus(403);
});

it('shows a specific roadmap', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    $roadmap = Roadmap::factory()->for($project)->create();

    $response = $this->actingAs($user)->getJson("/api/roadmaps/{$roadmap->id}");

    $response->assertStatus(200)
        ->assertJsonPath('id', $roadmap->id);
});

it('denies viewing another user roadmap', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();
    $roadmap = Roadmap::factory()->for($project)->create();

    $response = $this->actingAs($other)->getJson("/api/roadmaps/{$roadmap->id}");

    $response->assertStatus(403);
});
