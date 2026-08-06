<?php

use App\Models\Project;
use App\Models\Roadmap;
use App\Models\RoadmapStep;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->project = Project::factory()->for($this->user)->create();
    $this->roadmap = Roadmap::factory()->for($this->project)->create([
        'statut' => 'completed',
        'progression' => 0,
    ]);
    $this->step = RoadmapStep::factory()->for($this->roadmap)->create([
        'titre' => 'Première étape',
        'ordre' => 1,
        'statut' => 'pending',
    ]);
});

it('lists roadmaps for own project', function () {
    Roadmap::factory()->count(2)->for($this->project)->create();

    $response = $this->actingAs($this->user)
        ->getJson("/api/projects/{$this->project->id}/roadmaps");

    $response->assertStatus(200)
        ->assertJsonCount(3);
});

it('denies listing roadmaps for another user project', function () {
    $other = User::factory()->create();
    $otherProject = Project::factory()->for($other)->create();

    $response = $this->actingAs($this->user)
        ->getJson("/api/projects/{$otherProject->id}/roadmaps");

    $response->assertStatus(403);
});

it('shows roadmap with steps and progress', function () {
    RoadmapStep::factory()->for($this->roadmap)->create(['ordre' => 2, 'statut' => 'pending']);
    RoadmapStep::factory()->for($this->roadmap)->create(['ordre' => 3, 'statut' => 'completed']);

    $response = $this->actingAs($this->user)
        ->getJson("/api/roadmaps/{$this->roadmap->id}");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'id',
            'resume',
            'statut',
            'progression',
            'steps',
            'documents',
            'tax_obligations',
        ])
        ->assertJsonCount(3, 'steps');
});

it('updates step status pending to in_progress', function () {
    $response = $this->actingAs($this->user)
        ->patchJson("/api/roadmaps/{$this->roadmap->id}/steps/{$this->step->id}");

    $response->assertStatus(200)
        ->assertJsonPath('step.statut', 'in_progress');
});

it('updates step status in_progress to completed', function () {
    $this->step->update(['statut' => 'in_progress']);

    $response = $this->actingAs($this->user)
        ->patchJson("/api/roadmaps/{$this->roadmap->id}/steps/{$this->step->id}");

    $response->assertStatus(200)
        ->assertJsonPath('step.statut', 'completed');
});

it('rejects invalid step transition', function () {
    $this->step->update(['statut' => 'completed']);

    $response = $this->actingAs($this->user)
        ->patchJson("/api/roadmaps/{$this->roadmap->id}/steps/{$this->step->id}");

    $response->assertStatus(400);
});

it('recalculates progress after step update', function () {
    $step2 = RoadmapStep::factory()->for($this->roadmap)->create(['ordre' => 2, 'statut' => 'pending']);
    $step3 = RoadmapStep::factory()->for($this->roadmap)->create(['ordre' => 3, 'statut' => 'pending']);

    $this->actingAs($this->user)
        ->patchJson("/api/roadmaps/{$this->roadmap->id}/steps/{$this->step->id}");
    $this->actingAs($this->user)
        ->patchJson("/api/roadmaps/{$this->roadmap->id}/steps/{$this->step->id}");

    $this->assertEquals(33, $this->roadmap->fresh()->progression);

    $this->actingAs($this->user)
        ->patchJson("/api/roadmaps/{$this->roadmap->id}/steps/{$step2->id}");
    $this->actingAs($this->user)
        ->patchJson("/api/roadmaps/{$this->roadmap->id}/steps/{$step2->id}");

    $this->assertEquals(67, $this->roadmap->fresh()->progression);

    $this->actingAs($this->user)
        ->patchJson("/api/roadmaps/{$this->roadmap->id}/steps/{$step3->id}");
    $this->actingAs($this->user)
        ->patchJson("/api/roadmaps/{$this->roadmap->id}/steps/{$step3->id}");

    $this->assertEquals(100, $this->roadmap->fresh()->progression);
    $this->assertEquals('completed', $this->roadmap->fresh()->statut);
});

it('requires authentication for tracking endpoints', function () {
    $this->getJson("/api/projects/{$this->project->id}/roadmaps")->assertStatus(401);
    $this->getJson("/api/roadmaps/{$this->roadmap->id}")->assertStatus(401);
    $this->patchJson("/api/roadmaps/{$this->roadmap->id}/steps/{$this->step->id}")->assertStatus(401);
});

it('denies updating step of another user roadmap', function () {
    $other = User::factory()->create();
    $otherProject = Project::factory()->for($other)->create();
    $otherRoadmap = Roadmap::factory()->for($otherProject)->create();
    $otherStep = RoadmapStep::factory()->for($otherRoadmap)->create();

    $response = $this->actingAs($this->user)
        ->patchJson("/api/roadmaps/{$otherRoadmap->id}/steps/{$otherStep->id}");

    $response->assertStatus(403);
});
