<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Engagement;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create users
        User::factory(10)->create();

        // Create courses and assign users
        Course::factory(10)
            ->hasAttached(
                User::factory()->count(10),
                ['completed' => false]
            )
            ->create()
            ->each(function ($course) {
                // Seed engagement for each course-user pair
                foreach ($course->users as $user) {
                    Engagement::factory()->create([
                        'course_id' => $course->id,
                        'user_id' => $user->id,
                    ]);
                }
            });
    }
}
