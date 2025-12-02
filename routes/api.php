<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;

Route::prefix('v1')->group(function () {

    // Public endpoints
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected endpoints (Sanctum)
    Route::middleware('auth:sanctum')->group(function () {

        Route::apiResource('tasks', TaskController::class)->names('api.tasks');

        Route::post('/logout', [AuthController::class, 'logout']);
    });

});