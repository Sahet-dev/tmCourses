<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/teacher/courses', [CourseController::class, 'index']);
    Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::put('/courses/{id}', [CourseController::class, 'update']);
    Route::delete('/courses/{id}', [CourseController::class, 'destroy']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/courses/{course}/lessons', [LessonController::class, 'getLessons']);
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
    });

    // User routes
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);



    // Common routes for admin and teacher





});
