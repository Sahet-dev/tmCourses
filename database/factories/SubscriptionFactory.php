<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'plan' => $this->faker->randomElement(['basic', 'premium']),
            'starts_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'ends_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'status' => $this->faker->randomElement(['active', 'canceled']),
            'price' => $this->faker->randomFloat(2, 10, 200), // Add this line
        ];
    }
}
