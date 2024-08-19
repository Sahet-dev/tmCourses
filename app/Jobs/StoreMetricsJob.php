<?php

namespace App\Jobs;
use App\Models\AnalyticsMetric;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreMetricsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */

    public function handle()
    {
        $startDate = now()->subDay()->toDateString();
        $endDate = now()->toDateString();

        // Calculate metrics
        $activeUsers = User::getActiveUsers($startDate, $endDate);
        $newSubscriptions = Subscription::getNewSubscriptions($startDate, $endDate);
        $churnRate = Subscription::getChurnRate($startDate, $endDate);
        $retentionRate = Subscription::getRetentionRate(
            '2024-01-01', '2024-03-01', '2024-03-01', $endDate
        );

        // Save metrics to the database
        AnalyticsMetric::create([
            'active_users' => $activeUsers,
            'new_subscriptions' => $newSubscriptions,
            'churn_rate' => $churnRate,
            'retention_rate' => $retentionRate,
            'created_at' => now(),
        ]);
    }
}
