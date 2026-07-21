<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('allows admin to access admin routes', function () {
    $admin = User::factory()->admin()->create();
    $token = $admin->createToken('auth-token')->plainTextToken;

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->getJson('/api/admin/dashboard');

    $response->assertStatus(200);
});

it('blocks entrepreneur from admin routes', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth-token')->plainTextToken;

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->getJson('/api/admin/dashboard');

    $response->assertStatus(403);
});

it('blocks unauthenticated users from admin routes', function () {
    $response = $this->getJson('/api/admin/dashboard');

    $response->assertStatus(401);
});
