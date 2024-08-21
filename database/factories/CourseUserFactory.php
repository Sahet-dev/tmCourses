<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseUser>
 */
class CourseUserFactory extends Factory
{
    protected $model = CourseUser::class;

    public function definition()
    {
        $enrolledAt = Carbon::now()->subDays(rand(1, 30));
        $completed = $this->faker->boolean(70); // 70% chance of completion
        $completedAt = $completed ? $enrolledAt->copy()->addDays(rand(1, 30)) : null;

        return [
            'course_id' => Course::factory(),
            'user_id' => User::factory(),
            'enrolled_at' => $enrolledAt,
            'completed' => $completed,
            'completed_at' => $completedAt,
        ];
    }
}
