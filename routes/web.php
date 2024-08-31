<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentCourseController;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


use App\Http\Controllers\UserAuthController;




Route::get('/user-register', [UserAuthController::class, 'showRegisterForm'])->name('user.register');
Route::post('/user-register', [UserAuthController::class, 'register'])->name('user.register.submit');
// Show the login form for users
Route::get('/login-for-user', [UserAuthController::class, 'showLoginForm'])->name('user.login');

// Handle the login request for users
Route::post('/login-for-user', [UserAuthController::class, 'login'])->name('user.login.post');

// Handle the logout request for users

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
    Route::post('/logout-for-user', [UserAuthController::class, 'logout'])->name('user.logout');



});

Route::get('test-email', function () {
    Mail::raw('Test email content', function ($message) {
        $message->to('test@example.com')
            ->subject('Test Email');
    });

    return 'Email sent.';
});
require __DIR__.'/auth.php';
