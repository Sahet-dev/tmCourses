<?php

namespace Database\Factories;

use App\Models\Engagement;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class EngagementFactory extends Factory
{
    protected $model = Engagement::class;

    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'user_id' => User::factory(),
            'time_spent' => $this->faker->numberBetween(30, 600), // in minutes
            'interactions' => $this->faker->numberBetween(1, 50),
            'assignments_completed' => $this->faker->numberBetween(0, 10),
        ];
    }
}
