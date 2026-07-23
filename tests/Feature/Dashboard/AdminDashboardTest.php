<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('returns admin dashboard stats', function () {
    $admin = User::factory()->admin()->create();
    User::factory()->count(3)->create();

    $response = $this->actingAs($admin)->getJson('/api/admin/dashboard');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'total_users',
            'users_by_role',
            'total_projects',
            'projects_by_status',
            'total_roadmaps',
            'roadmaps_by_status',
            'recent_users',
        ])
        ->assertJsonPath('total_users', 4);
});

it('blocks entrepreneurs from admin dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->getJson('/api/admin/dashboard');

    $response->assertStatus(403);
});

it('requires authentication for admin dashboard', function () {
    $response = $this->getJson('/api/admin/dashboard');

    $response->assertStatus(401);
});
