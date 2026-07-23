<?php

use App\Http\Controllers\Admin\LegalStructureController as AdminLegalStructureController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LegalStructureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/legal-structures', [LegalStructureController::class, 'index']);
Route::get('/legal-structures/{id}', [LegalStructureController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return response()->json(['message' => 'Admin dashboard']);
    });

    Route::apiResource('legal-structures', AdminLegalStructureController::class)
        ->only(['store', 'update', 'destroy']);
});
