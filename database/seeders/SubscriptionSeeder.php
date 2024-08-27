<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        Subscription::create([
            'user_id' => 1,
            'starts_at' => Carbon::parse('2024-01-10'),
            'created_at' => Carbon::parse('2024-01-10'),
            'status' => 'active',
            'plan' => 'basic',
            'price' => 50.00, // Add price
        ]);

        Subscription::create([
            'user_id' => 2,
            'starts_at' => Carbon::parse('2024-02-01'),
            'created_at' => Carbon::parse('2024-02-01'),
            'updated_at' => Carbon::parse('2024-05-01'),
            'status' => 'canceled',
            'plan' => 'premium',
            'price' => 75.00, // Add price
        ]);

        Subscription::create([
            'user_id' => 3,
            'starts_at' => Carbon::parse('2024-01-15'),
            'created_at' => Carbon::parse('2024-01-15'),
            'status' => 'active',
            'plan' => 'basic',
            'price' => 60.00, // Add price
        ]);

        Subscription::create([
            'user_id' => 3,
            'starts_at' => Carbon::parse('2024-04-15'),
            'created_at' => Carbon::parse('2024-04-15'),
            'status' => 'active',
            'plan' => 'premium',
            'price' => 100.00, // Add price
        ]);
    }
}
