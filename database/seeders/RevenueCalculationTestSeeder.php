<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Engagement;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RevenueCalculationTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create teachers
        $teachers = User::factory(3)->create(['role' => 'teacher']);

        // Create students
        $students = User::factory(10)->create(['role' => 'student']);

        foreach ($teachers as $teacher) {
            // Create courses for each teacher
            $courses = Course::factory(3)->create(['teacher_id' => $teacher->id, 'price' => rand(50, 200)]);

            foreach ($courses as $course) {
                // Attach students to each course
                foreach ($students as $student) {
                    $course->users()->attach($student->id, [
                        'completed' => rand(0, 1),
                        'enrolled_at' => now()->subDays(rand(1, 60)),
                        'completed_at' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
                    ]);

                    // Create engagements for each student in the course
                    Engagement::factory(1)->create([
                        'course_id' => $course->id,
                        'user_id' => $student->id,
                    ]);
                }
            }
        }

        // Create subscriptions for some students to simulate revenue
        Subscription::factory(5)->create([
            'status' => 'active',
            'plan' => 'premium',
            'starts_at' => now()->subMonths(1),
            'ends_at' => now()->addMonths(11),
        ]);
    }
}
