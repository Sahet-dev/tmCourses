<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::put('/courses/{id}', [CourseController::class, 'update']);
    Route::get('/teacher/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::delete('/courses/{id}', [CourseController::class, 'destroy']);


    Route::get('/courses/{id}/lessons', [LessonController::class, 'fetchLessons']);
    Route::put('/lessons/{id}', [LessonController::class, 'update']);
    Route::get('/courses/{course}/lessons', [LessonController::class, 'getLessons']);
    Route::post('/courses/{course}/lessons', [LessonController::class, 'store']);


    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::get('/analytics/course-engagement', [AnalyticsController::class, 'index']);
    Route::get('/analytics/active-users', [AnalyticsController::class, 'activeUsers']);
    Route::get('/analytics/new-subscriptions', [AnalyticsController::class, 'newSubscriptions']);
    Route::get('/analytics/churn-rate', [AnalyticsController::class, 'churnRate']);
    Route::get('/analytics/retention-rate', [AnalyticsController::class, 'retentionRate']);









});
