<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns entrepreneur dashboard stats', function () {
    $user = User::factory()->create();
    Project::factory()->count(3)->for($user)->create(['statut' => 'en_cours']);

    $response = $this->actingAs($user)->getJson('/api/dashboard');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'projects_count',
            'projects_by_status',
            'roadmaps_count',
            'roadmaps_by_status',
            'global_progression',
            'recent_roadmaps',
        ])
        ->assertJsonPath('projects_count', 3);
});

it('returns zero stats when user has no projects', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->getJson('/api/dashboard');

    $response->assertStatus(200)
        ->assertJsonPath('projects_count', 0)
        ->assertJsonPath('roadmaps_count', 0)
        ->assertJsonPath('global_progression', 0);
});

it('does not show other users data', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    Project::factory()->count(5)->for($other)->create();

    $response = $this->actingAs($user)->getJson('/api/dashboard');

    $response->assertStatus(200)
        ->assertJsonPath('projects_count', 0);
});

it('requires authentication', function () {
    $response = $this->getJson('/api/dashboard');

    $response->assertStatus(401);
});
