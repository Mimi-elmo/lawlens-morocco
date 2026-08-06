<?php

use App\Models\LegalRule;
use App\Models\User;
use Database\Seeders\LegalRuleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(LegalRuleSeeder::class);
    $this->admin = User::factory()->admin()->create();
    $this->entrepreneur = User::factory()->create();
});

it('lists all rules including inactive', function () {
    LegalRule::create([
        'titre' => 'Inactive Rule',
        'description' => 'Should appear for admin',
        'categorie' => 'legal',
        'statut' => 'inactive',
    ]);

    $response = $this->actingAs($this->admin)->getJson('/api/admin/legal-rules');

    $response->assertStatus(200)
        ->assertJsonCount(11)
        ->assertJsonFragment(['titre' => 'Inactive Rule']);
});

it('creates a legal rule', function () {
    $response = $this->actingAs($this->admin)->postJson('/api/admin/legal-rules', [
        'titre' => 'Nouvelle règle',
        'categorie' => 'fiscal',
        'source' => 'Test source',
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('legal_rule.titre', 'Nouvelle règle');

    $this->assertDatabaseHas('legal_rules', [
        'titre' => 'Nouvelle règle',
    ]);
});

it('validates required fields on store', function () {
    $response = $this->actingAs($this->admin)->postJson('/api/admin/legal-rules', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['titre', 'categorie']);
});

it('shows any legal rule by id', function () {
    $response = $this->actingAs($this->admin)->getJson('/api/admin/legal-rules/1');

    $response->assertStatus(200)
        ->assertJsonPath('titre', "Obligation d'immatriculation au Registre du Commerce");
});

it('updates a legal rule', function () {
    $response = $this->actingAs($this->admin)->putJson('/api/admin/legal-rules/1', [
        'titre' => 'Titre modifié',
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('legal_rule.titre', 'Titre modifié');
});

it('deletes a legal rule', function () {
    $response = $this->actingAs($this->admin)->deleteJson('/api/admin/legal-rules/1');

    $response->assertStatus(200)
        ->assertJson(['message' => 'Règle juridique supprimée avec succès.']);

    $this->assertDatabaseMissing('legal_rules', ['id' => 1]);
});

it('denies access to non-admin users', function () {
    $response = $this->actingAs($this->entrepreneur)->getJson('/api/admin/legal-rules');

    $response->assertStatus(403);
});

it('requires authentication', function () {
    $response = $this->getJson('/api/admin/legal-rules');

    $response->assertStatus(401);
});
