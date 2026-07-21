<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('allows user to view own project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();

    expect(Gate::forUser($user)->allows('view', $project))->toBeTrue();
});

it('denies user from viewing another user project', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();

    expect(Gate::forUser($other)->denies('view', $project))->toBeTrue();
});

it('denies user from updating another user project', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();

    expect(Gate::forUser($other)->denies('update', $project))->toBeTrue();
});

it('denies user from deleting another user project', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();

    expect(Gate::forUser($other)->denies('delete', $project))->toBeTrue();
});

it('allows user to create a project', function () {
    $user = User::factory()->create();

    expect(Gate::forUser($user)->allows('create', Project::class))->toBeTrue();
});
