<?php

use App\Models\Project;
use App\Models\Roadmap;
use App\Models\RoadmapStep;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('updates step status and progression', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    $roadmap = Roadmap::factory()->for($project)->create(['progression' => 0]);
    RoadmapStep::factory()->count(4)->for($roadmap)->create(['statut' => 'pending']);
    $step = $roadmap->steps()->first();

    $response = $this->actingAs($user)->putJson("/api/roadmap-steps/{$step->id}", [
        'statut' => 'completed',
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('step.statut', 'completed')
        ->assertJsonPath('progression', 25);
});

it('denies updating step for another user roadmap', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();
    $roadmap = Roadmap::factory()->for($project)->create();
    $step = RoadmapStep::factory()->for($roadmap)->create();

    $response = $this->actingAs($other)->putJson("/api/roadmap-steps/{$step->id}", [
        'statut' => 'completed',
    ]);

    $response->assertStatus(403);
});

it('validates required statut field', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    $roadmap = Roadmap::factory()->for($project)->create();
    $step = RoadmapStep::factory()->for($roadmap)->create();

    $response = $this->actingAs($user)->putJson("/api/roadmap-steps/{$step->id}", []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['statut']);
});

it('validates statut enum values', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();
    $roadmap = Roadmap::factory()->for($project)->create();
    $step = RoadmapStep::factory()->for($roadmap)->create();

    $response = $this->actingAs($user)->putJson("/api/roadmap-steps/{$step->id}", [
        'statut' => 'invalid',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['statut']);
});
