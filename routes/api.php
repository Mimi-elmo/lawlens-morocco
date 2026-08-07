<?php

use App\Http\Controllers\Admin\LegalRuleController as AdminLegalRuleController;
use App\Http\Controllers\Admin\LegalStructureController as AdminLegalStructureController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LegalRuleController;
use App\Http\Controllers\LegalStructureController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoadmapController;
use Illuminate\Support\Facades\Route;

Route::get('/legal-structures', [LegalStructureController::class, 'index']);
Route::get('/legal-structures/{id}', [LegalStructureController::class, 'show']);

Route::get('/legal-rules', [LegalRuleController::class, 'index']);
Route::get('/legal-rules/{id}', [LegalRuleController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/dashboard', [DashboardController::class, 'entrepreneur']);

    Route::apiResource('projects', ProjectController::class)->names([
    'index' => 'api.projects.index',
    'store' => 'api.projects.store',
    'show' => 'api.projects.show',
    'update' => 'api.projects.update',
    'destroy' => 'api.projects.destroy',
]);

    Route::get('/projects/{project}/roadmaps', [RoadmapController::class, 'index']);
    Route::post('/projects/{project}/roadmaps', [RoadmapController::class, 'generate']);
    Route::get('/roadmaps/{roadmap}', [RoadmapController::class, 'show']);
    Route::put('/roadmap-steps/{step}', [RoadmapController::class, 'updateStep']);
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin']);

    Route::apiResource('legal-structures', AdminLegalStructureController::class)
        ->only(['store', 'update', 'destroy']);

    Route::apiResource('legal-rules', AdminLegalRuleController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
});
