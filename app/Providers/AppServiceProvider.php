<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\User;
use App\Policies\CoursePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Course::class, CoursePolicy::class);
        Validator::extend('max_post_size', function ($attribute, $value, $parameters, $validator) {
            $maxSize = min(ini_get('post_max_size'), ini_get('upload_max_filesize'));
            return strlen($value) <= $maxSize * 1024 * 1024;
        });
    }
}
