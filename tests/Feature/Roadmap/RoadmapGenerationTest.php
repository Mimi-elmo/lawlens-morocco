<?php

use App\DataTransferObjects\RoadmapResult;
use App\Jobs\GenerateRoadmapJob;
use App\Models\LegalStructure;
use App\Models\Project;
use App\Models\Roadmap;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->project = Project::factory()->for($this->user)->create();
});

it('dispatches a job when generating roadmap', function () {
    Queue::fake();

    $response = $this->actingAs($this->user)
        ->postJson("/api/projects/{$this->project->id}/generate-roadmap");

    $response->assertStatus(202)
        ->assertJson(['message' => 'Génération du roadmap lancée.']);

    Queue::assertPushed(GenerateRoadmapJob::class, function ($job) {
        return $job->project->id === $this->project->id;
    });
});

it('creates a pending roadmap record before dispatch', function () {
    Queue::fake();

    $this->actingAs($this->user)
        ->postJson("/api/projects/{$this->project->id}/generate-roadmap");

    $this->assertDatabaseHas('roadmaps', [
        'project_id' => $this->project->id,
        'statut' => 'pending',
    ]);
});

it('returns 409 if roadmap already being generated', function () {
    Queue::fake();

    $this->project->roadmaps()->create(['statut' => 'generating', 'date_generation' => now()]);

    $response = $this->actingAs($this->user)
        ->postJson("/api/projects/{$this->project->id}/generate-roadmap");

    $response->assertStatus(409);
});

it('denies generating roadmap for another user project', function () {
    $other = User::factory()->create();
    $otherProject = Project::factory()->for($other)->create();

    $response = $this->actingAs($this->user)
        ->postJson("/api/projects/{$otherProject->id}/generate-roadmap");

    $response->assertStatus(403);
});

it('requires authentication for roadmap generation', function () {
    $response = $this->postJson("/api/projects/{$this->project->id}/generate-roadmap");

    $response->assertStatus(401);
});

it('processes job and creates roadmap with all relations', function () {
    LegalStructure::factory()->create(['slug' => 'sarl', 'nom' => 'SARL']);

    $result = new RoadmapResult(
        summary: 'Résumé test',
        recommendedLegalStructure: 'sarl',
        steps: [
            ['titre' => 'Étape 1', 'description' => 'Description 1', 'ordre' => 1],
            ['titre' => 'Étape 2', 'description' => 'Description 2', 'ordre' => 2],
        ],
        requiredDocuments: [
            ['nom' => 'Document 1', 'description' => 'Description doc', 'obligatoire' => true],
        ],
        taxObligations: [
            ['nom' => 'Taxe 1', 'description' => 'Description taxe', 'frequence' => 'annuelle', 'obligatoire' => true],
        ],
        legalReferences: [
            ['titre' => 'Loi 1', 'source' => 'Source 1'],
        ],
        warnings: [
            ['message' => 'Attention 1'],
        ]
    );

    $generator = Mockery::mock('App\Services\RoadmapGenerator');
    $generator->shouldReceive('generate')
        ->once()
        ->with(Mockery::type(Project::class))
        ->andReturnUsing(function ($project) use ($result) {
            $roadmap = $project->roadmaps()->create([
                'statut' => 'generating',
                'date_generation' => now(),
            ]);

            $structure = LegalStructure::where('slug', 'sarl')->first();

            return $project->roadmaps()->create([
                'forme_juridique_recommandee_id' => $structure?->id,
                'resume' => $result->summary,
                'statut' => 'completed',
                'progression' => 0,
                'date_generation' => now(),
            ]);
        });

    $job = new GenerateRoadmapJob($this->project);
    $job->handle($generator);

    $this->assertDatabaseHas('roadmaps', [
        'project_id' => $this->project->id,
        'statut' => 'completed',
        'resume' => 'Résumé test',
    ]);
});

it('marks job as failed on exception', function () {
    $generator = Mockery::mock('App\Services\RoadmapGenerator');
    $generator->shouldReceive('generate')
        ->once()
        ->andThrow(new \Exception('AI service unavailable'));

    $job = new GenerateRoadmapJob($this->project);

    try {
        $job->handle($generator);
    } catch (\Exception $e) {
        $job->failed($e);
    }

    $this->assertDatabaseHas('roadmaps', [
        'project_id' => $this->project->id,
        'statut' => 'failed',
    ]);
});
