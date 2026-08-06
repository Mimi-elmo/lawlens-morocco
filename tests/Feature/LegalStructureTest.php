<?php

use App\Models\LegalStructure;
use Database\Seeders\LegalStructureSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(LegalStructureSeeder::class);
});

it('returns all active legal structures', function () {
    $response = $this->getJson('/api/legal-structures');

    $response->assertStatus(200)
        ->assertJsonCount(6);
});

it('returns a single legal structure by id', function () {
    $response = $this->getJson('/api/legal-structures/1');

    $response->assertStatus(200)
        ->assertJson([
            'id' => 1,
            'nom' => 'Auto-entrepreneur',
            'slug' => 'auto-entrepreneur',
        ]);
});

it('returns 404 for non-existent legal structure', function () {
    $response = $this->getJson('/api/legal-structures/999');

    $response->assertStatus(404);
});

it('has correct json structure', function () {
    $response = $this->getJson('/api/legal-structures/1');

    $response->assertJsonStructure([
        'id',
        'nom',
        'slug',
        'description',
        'capital_information',
        'tax_information',
    ]);
});

it('only returns active structures', function () {
    LegalStructure::create([
        'nom' => 'Inactive Structure',
        'slug' => 'inactive',
        'description' => 'Should not appear',
        'statut' => 'inactive',
    ]);

    $response = $this->getJson('/api/legal-structures');

    $response->assertStatus(200)
        ->assertJsonCount(6)
        ->assertJsonMissing(['nom' => 'Inactive Structure']);
});
