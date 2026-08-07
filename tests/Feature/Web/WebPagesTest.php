<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the welcome page', function () {
    $response = $this->get('/');

    $response->assertOk();
});

it('renders the login page', function () {
    $response = $this->get('/login');

    $response->assertOk();
});

it('renders the register page', function () {
    $response = $this->get('/register');

    $response->assertOk();
});

it('renders the dashboard for an authenticated user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
});

it('renders the projects pages for an authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/projects')->assertOk();
    $this->actingAs($user)->get('/projects/create')->assertOk();
});

it('renders the roadmaps page for an authenticated user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/roadmaps');

    $response->assertOk();
});

it('renders the admin dashboard for an administrator', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get('/admin/dashboard');

    $response->assertOk();
});

it('redirects guests to login for protected pages', function (string $uri) {
    $this->get($uri)->assertRedirect(route('login'));
})->with([
    '/dashboard',
    '/projects',
    '/projects/create',
    '/roadmaps',
]);
