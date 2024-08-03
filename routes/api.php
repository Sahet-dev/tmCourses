<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Creator routes
    Route::middleware('role:teacher, cors')->group(function () {
        Route::post('/courses', [CourseController::class, 'store']);
    });

    // Common routes for admin and teacher
    Route::middleware('role:admin,teacher')->group(function () {
        Route::get('/courses', [CourseController::class, 'index']);
        Route::get('/courses/{id}', [CourseController::class, 'show']);
    });

    // Admin-specific routes
    Route::middleware('role:admin')->group(function () {
        Route::put('/courses/{id}', [CourseController::class, 'update']);
        Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
    });
});
