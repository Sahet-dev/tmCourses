<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function activeUsers(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $activeUsers = User::getActiveUsers($startDate, $endDate);

        return response()->json(['active_users' => $activeUsers]);
    }

    public function newSubscriptions(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $newSubscriptions = Subscription::getNewSubscriptions($startDate, $endDate);

        return response()->json(['new_subscriptions' => $newSubscriptions]);
    }

    public function churnRate(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $churnRate = Subscription::getChurnRate($startDate, $endDate);

        return response()->json(['churn_rate' => $churnRate]);
    }

    public function retentionRate(Request $request)
    {
        $initialPeriodStart = $request->query('initial_period_start');
        $initialPeriodEnd = $request->query('initial_period_end');
        $retentionPeriodStart = $request->query('retention_period_start');
        $retentionPeriodEnd = $request->query('retention_period_end');

        $retentionRate = Subscription::getRetentionRate($initialPeriodStart, $initialPeriodEnd, $retentionPeriodStart, $retentionPeriodEnd);

        return response()->json(['retention_rate' => $retentionRate]);
    }
}
