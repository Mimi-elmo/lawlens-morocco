<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the edit page with prefilled project values', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create([
        'nom' => 'Boulangerie Atlas',
        'description' => 'Boulangerie artisanale à Marrakech',
        'type_activite' => 'societe',
        'statut' => 'en_cours',
    ]);

    $response = $this->actingAs($user)->get("/projects/{$project->id}/edit");

    $response->assertOk();
    $response->assertSee('Boulangerie Atlas');
    $response->assertSee('Boulangerie artisanale à Marrakech');
    $response->assertSee('societe', false);
    $response->assertSee('en_cours', false);
});

it('updates the project and redirects to the show page', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();

    $response = $this->actingAs($user)->put("/projects/{$project->id}", [
        'nom' => 'Projet renommé',
        'activite' => 'E-commerce',
        'description' => null,
        'ville' => 'Casablanca',
        'budget' => 100000,
        'nombre_associes' => 2,
        'type_activite' => 'societe',
        'statut' => 'en_cours',
    ]);

    $response->assertRedirect(route('projects.show', $project));

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'nom' => 'Projet renommé',
        'activite' => 'E-commerce',
        'type_activite' => 'societe',
        'statut' => 'en_cours',
    ]);
});

it('denies editing a project owned by another user', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();

    $this->actingAs($other)->get("/projects/{$project->id}/edit")->assertForbidden();
    $this->actingAs($other)->put("/projects/{$project->id}", [
        'nom' => 'Intrusion',
    ])->assertForbidden();
});