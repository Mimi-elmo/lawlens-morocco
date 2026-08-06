<?php

use App\Models\LegalRule;
use Database\Seeders\LegalRuleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(LegalRuleSeeder::class);
});

it('returns all active legal rules', function () {
    $response = $this->getJson('/api/legal-rules');

    $response->assertStatus(200)
        ->assertJsonCount(10);
});

it('returns a single legal rule by id', function () {
    $response = $this->getJson('/api/legal-rules/1');

    $response->assertStatus(200)
        ->assertJson([
            'id' => 1,
            'titre' => "Obligation d'immatriculation au Registre du Commerce",
            'categorie' => 'legal',
        ]);
});

it('returns 404 for non-existent legal rule', function () {
    $response = $this->getJson('/api/legal-rules/999');

    $response->assertStatus(404);
});

it('has correct json structure', function () {
    $response = $this->getJson('/api/legal-rules/1');

    $response->assertJsonStructure([
        'id',
        'titre',
        'description',
        'categorie',
        'source',
        'date_entree_vigueur',
    ]);
});

it('only returns active rules', function () {
    LegalRule::create([
        'titre' => 'Inactive Rule',
        'description' => 'Should not appear',
        'categorie' => 'legal',
        'statut' => 'inactive',
    ]);

    $response = $this->getJson('/api/legal-rules');

    $response->assertStatus(200)
        ->assertJsonCount(10)
        ->assertJsonMissing(['titre' => 'Inactive Rule']);
});
