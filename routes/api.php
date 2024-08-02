<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Routes for authentication
Route::post('/login', [AuthController::class, 'login']);

// Routes protected by Sanctum authentication
Route::middleware('auth:sanctum')->group(function () {
    // User-specific routes
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes for creating a course, only accessible by users with the 'create' ability
    Route::middleware('role:creator')->group(function () {
        Route::post('/courses', [CourseController::class, 'store']);
    });

    // Routes for admin users
    Route::middleware('role:admin')->group(function () {
        Route::get('/courses', [CourseController::class, 'index']);
        Route::get('/courses/{id}', [CourseController::class, 'show']);
        Route::put('/courses/{id}', [CourseController::class, 'update']);
        Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
    });

    // Routes for teacher users
    Route::middleware('role:teacher')->group(function () {
        Route::get('/courses', [CourseController::class, 'index']);
        Route::get('/courses/{id}', [CourseController::class, 'show']);
    });
});
