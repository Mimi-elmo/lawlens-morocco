<?php

use App\Models\LegalStructure;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->adminToken = $this->admin->createToken('auth-token')->plainTextToken;

    $this->user = User::factory()->create();
    $this->userToken = $this->user->createToken('auth-token')->plainTextToken;
});

it('admin can create a legal structure', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$this->adminToken,
    ])->postJson('/api/admin/legal-structures', [
        'nom' => 'Nouvelle Structure',
        'slug' => 'nouvelle-structure',
        'description' => 'Description test',
    ]);

    $response->assertStatus(201)
        ->assertJson([
            'message' => 'Structure juridique créée avec succès.',
        ]);

    expect(LegalStructure::where('slug', 'nouvelle-structure')->exists())->toBeTrue();
});

it('admin can update a legal structure', function () {
    $structure = LegalStructure::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$this->adminToken,
    ])->putJson("/api/admin/legal-structures/{$structure->id}", [
        'nom' => 'Structure Modifiée',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Structure juridique mise à jour avec succès.',
        ]);

    expect($structure->fresh()->nom)->toBe('Structure Modifiée');
});

it('admin can delete a legal structure', function () {
    $structure = LegalStructure::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$this->adminToken,
    ])->deleteJson("/api/admin/legal-structures/{$structure->id}");

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Structure juridique supprimée avec succès.',
        ]);

    expect(LegalStructure::find($structure->id))->toBeNull();
});

it('entrepreneur cannot create a legal structure', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$this->userToken,
    ])->postJson('/api/admin/legal-structures', [
        'nom' => 'Test',
        'slug' => 'test',
    ]);

    $response->assertStatus(403);
});

it('entrepreneur cannot update a legal structure', function () {
    $structure = LegalStructure::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$this->userToken,
    ])->putJson("/api/admin/legal-structures/{$structure->id}", [
        'nom' => 'Hacked',
    ]);

    $response->assertStatus(403);
});

it('entrepreneur cannot delete a legal structure', function () {
    $structure = LegalStructure::factory()->create();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$this->userToken,
    ])->deleteJson("/api/admin/legal-structures/{$structure->id}");

    $response->assertStatus(403);
});

it('validates required fields on create', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$this->adminToken,
    ])->postJson('/api/admin/legal-structures', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['nom', 'slug']);
});

it('validates unique slug on create', function () {
    LegalStructure::factory()->create(['slug' => 'existant']);

    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$this->adminToken,
    ])->postJson('/api/admin/legal-structures', [
        'nom' => 'Test',
        'slug' => 'existant',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['slug']);
});
