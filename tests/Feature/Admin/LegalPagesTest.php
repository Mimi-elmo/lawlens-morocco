<?php

use App\Models\LegalRule;
use App\Models\LegalStructure;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->user = User::factory()->create();
});

it('lists legal structures for admin', function () {
    LegalStructure::factory()->create(['nom' => 'SARL']);

    $this->actingAs($this->admin)
        ->get(route('admin.structures.index'))
        ->assertOk()
        ->assertSee('SARL');
});

it('shows the create structure form', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.structures.create'))
        ->assertOk();
});

it('creates a legal structure with auto slug', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.structures.store'), [
            'nom' => 'Société à Responsabilité Limitée',
            'description' => 'Forme juridique la plus répandue.',
            'statut' => 'active',
        ])
        ->assertRedirect(route('admin.structures.index'));

    $this->assertDatabaseHas('legal_structures', [
        'nom' => 'Société à Responsabilité Limitée',
        'slug' => 'societe-a-responsabilite-limitee',
    ]);
});

it('generates a unique slug when the slug already exists', function () {
    LegalStructure::factory()->create(['nom' => 'SARL', 'slug' => 'sarl']);

    $this->actingAs($this->admin)
        ->post(route('admin.structures.store'), ['nom' => 'SARL'])
        ->assertRedirect(route('admin.structures.index'));

    $this->assertDatabaseHas('legal_structures', ['slug' => 'sarl-1']);
});

it('shows the edit structure form', function () {
    $structure = LegalStructure::factory()->create();

    $this->actingAs($this->admin)
        ->get(route('admin.structures.edit', $structure))
        ->assertOk()
        ->assertSee($structure->nom);
});

it('updates a legal structure', function () {
    $structure = LegalStructure::factory()->create(['nom' => 'SARL']);

    $this->actingAs($this->admin)
        ->put(route('admin.structures.update', $structure), [
            'nom' => 'SA',
            'statut' => 'inactive',
        ])
        ->assertRedirect(route('admin.structures.index'));

    $this->assertDatabaseHas('legal_structures', [
        'id' => $structure->id,
        'nom' => 'SA',
        'slug' => 'sa',
        'statut' => 'inactive',
    ]);
});

it('deletes a legal structure', function () {
    $structure = LegalStructure::factory()->create();

    $this->actingAs($this->admin)
        ->delete(route('admin.structures.destroy', $structure))
        ->assertRedirect(route('admin.structures.index'));

    $this->assertDatabaseMissing('legal_structures', ['id' => $structure->id]);
});

it('lists legal rules for admin', function () {
    LegalRule::factory()->create(['titre' => 'Cessation activité']);

    $this->actingAs($this->admin)
        ->get(route('admin.rules.index'))
        ->assertOk()
        ->assertSee('Cessation activité');
});

it('shows the create rule form', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.rules.create'))
        ->assertOk();
});

it('creates a legal rule', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.rules.store'), [
            'titre' => 'Déclaration de cessation',
            'categorie' => 'fiscal',
            'source' => 'DGI',
            'date_entree_vigueur' => '2024-01-01',
            'statut' => 'active',
        ])
        ->assertRedirect(route('admin.rules.index'));

    $this->assertDatabaseHas('legal_rules', [
        'titre' => 'Déclaration de cessation',
        'categorie' => 'fiscal',
        'source' => 'DGI',
    ]);
});

it('shows the edit rule form', function () {
    $rule = LegalRule::factory()->create();

    $this->actingAs($this->admin)
        ->get(route('admin.rules.edit', $rule))
        ->assertOk()
        ->assertSee($rule->titre);
});

it('updates a legal rule', function () {
    $rule = LegalRule::factory()->create(['titre' => 'Ancien titre']);

    $this->actingAs($this->admin)
        ->put(route('admin.rules.update', $rule), [
            'titre' => 'Nouveau titre',
            'categorie' => 'legal',
            'statut' => 'inactive',
        ])
        ->assertRedirect(route('admin.rules.index'));

    $this->assertDatabaseHas('legal_rules', [
        'id' => $rule->id,
        'titre' => 'Nouveau titre',
        'statut' => 'inactive',
    ]);
});

it('deletes a legal rule', function () {
    $rule = LegalRule::factory()->create();

    $this->actingAs($this->admin)
        ->delete(route('admin.rules.destroy', $rule))
        ->assertRedirect(route('admin.rules.index'));

    $this->assertDatabaseMissing('legal_rules', ['id' => $rule->id]);
});

it('denies access to structure pages for non-admin users', function () {
    $structure = LegalStructure::factory()->create();

    $this->actingAs($this->user)
        ->get(route('admin.structures.index'))
        ->assertRedirect(route('dashboard'));

    $this->actingAs($this->user)
        ->post(route('admin.structures.store'), ['nom' => 'SARL'])
        ->assertRedirect(route('dashboard'));

    $this->actingAs($this->user)
        ->put(route('admin.structures.update', $structure), ['nom' => 'SA'])
        ->assertRedirect(route('dashboard'));

    $this->actingAs($this->user)
        ->delete(route('admin.structures.destroy', $structure))
        ->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('legal_structures', ['id' => $structure->id]);
});

it('denies access to rule pages for non-admin users', function () {
    $rule = LegalRule::factory()->create();

    $this->actingAs($this->user)
        ->get(route('admin.rules.index'))
        ->assertRedirect(route('dashboard'));

    $this->actingAs($this->user)
        ->post(route('admin.rules.store'), ['titre' => 'Règle', 'categorie' => 'legal'])
        ->assertRedirect(route('dashboard'));

    $this->actingAs($this->user)
        ->delete(route('admin.rules.destroy', $rule))
        ->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('legal_rules', ['id' => $rule->id]);
});

it('redirects guests to login for admin pages', function () {
    $this->get(route('admin.structures.index'))
        ->assertRedirect(route('login'));
});