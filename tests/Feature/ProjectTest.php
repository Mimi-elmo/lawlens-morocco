<?php

use App\Models\Project;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('lists authenticated user projects', function () {
    $user = User::factory()->create();
    Project::factory()->count(3)->for($user)->create();
    Project::factory()->count(2)->create();

    $response = $this->actingAs($user)->getJson('/api/projects');

    $response->assertStatus(200)
        ->assertJsonCount(3);
});

it('returns empty list when user has no projects', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->getJson('/api/projects');

    $response->assertStatus(200)
        ->assertJsonCount(0);
});

it('creates a project', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/projects', [
        'nom' => 'Mon Projet',
        'activite' => 'Consulting',
        'ville' => 'Casablanca',
        'nombre_associes' => 2,
        'type_activite' => 'individuelle',
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'message' => 'Projet créé avec succès.',
        ])
        ->assertJsonPath('project.nom', 'Mon Projet');

    $this->assertDatabaseHas('projects', [
        'nom' => 'Mon Projet',
        'user_id' => $user->id,
    ]);
});

it('validates required fields on store', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/projects', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['nom', 'activite', 'ville', 'nombre_associes', 'type_activite']);
});

it('shows own project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();

    $response = $this->actingAs($user)->getJson("/api/projects/{$project->id}");

    $response->assertStatus(200)
        ->assertJsonPath('id', $project->id);
});

it('denies viewing another user project', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();

    $response = $this->actingAs($other)->getJson("/api/projects/{$project->id}");

    $response->assertStatus(403);
});

it('updates own project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create(['nom' => 'Ancien nom']);

    $response = $this->actingAs($user)->putJson("/api/projects/{$project->id}", [
        'nom' => 'Nouveau nom',
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('project.nom', 'Nouveau nom');
});

it('denies updating another user project', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();

    $response = $this->actingAs($other)->putJson("/api/projects/{$project->id}", [
        'nom' => 'Hijacked',
    ]);

    $response->assertStatus(403);
});

it('deletes own project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();

    $response = $this->actingAs($user)->deleteJson("/api/projects/{$project->id}");

    $response->assertStatus(200)
        ->assertJson(['message' => 'Projet supprimé avec succès.']);

    $this->assertModelMissing($project);
});

it('denies deleting another user project', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();

    $response = $this->actingAs($other)->deleteJson("/api/projects/{$project->id}");

    $response->assertStatus(403);
});

it('requires authentication', function () {
    $response = $this->getJson('/api/projects');

    $response->assertStatus(401);
});
