<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentCourseController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


route::get('/login', [AuthController::class, 'login'])->name('login');
route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/courses', [HomeController::class, 'search'])->name('courses.search');
Route::get('/', [HomeController::class, 'main'])->name('main-page');
Route::get('/courses/{id}', [HomeController::class, 'show'])->name('courseDetail');
Route::get('/{any}', function () {
    return Inertia::render('MainPage');
})->where('any', '.*');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/notifications', [HomeController::class, 'notificationsPage'])->name('notifications');


});


require __DIR__.'/auth.php';
