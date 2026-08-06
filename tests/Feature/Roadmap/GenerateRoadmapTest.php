<?php

use App\Jobs\GenerateRoadmap;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

it('dispatches roadmap generation job', function () {
    Queue::fake();

    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();

    $response = $this->actingAs($user)->postJson("/api/projects/{$project->id}/roadmaps");

    $response->assertStatus(202)
        ->assertJson(['message' => 'Génération de la feuille de route lancée.']);

    Queue::assertPushed(GenerateRoadmap::class);
});

it('denies generation for another user project', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();

    $response = $this->actingAs($other)->postJson("/api/projects/{$project->id}/roadmaps");

    $response->assertStatus(403);
});

it('requires authentication for generation', function () {
    $project = Project::factory()->create();

    $response = $this->postJson("/api/projects/{$project->id}/roadmaps");

    $response->assertStatus(401);
});
