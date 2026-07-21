<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can register a new user', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Test Entrepreneur',
        'email' => 'entrepreneur@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'user' => ['id', 'name', 'email', 'role'],
            'token',
        ]);

    expect($response->json('user.role'))->toBe('entrepreneur');
    expect(User::where('email', 'entrepreneur@test.com')->exists())->toBeTrue();
});

it('requires password confirmation', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Test',
        'email' => 'test@test.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(422);
});

it('requires unique email', function () {
    User::factory()->create(['email' => 'duplicate@test.com']);

    $response = $this->postJson('/api/register', [
        'name' => 'Test',
        'email' => 'duplicate@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

it('requires minimum 8 character password', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Test',
        'email' => 'test@test.com',
        'password' => 'short',
        'password_confirmation' => 'short',
    ]);

    $response->assertStatus(422);
});
