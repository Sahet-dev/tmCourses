<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{

    public function index()
    {
        // Fetch all popular courses based on enrollments
        $popularCourses = Course::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(5)
            ->get();

        // Fetch course completion rates
        $completionRates = Course::withCount([
            'users as completed_users_count' => function ($query) {
                $query->where('course_user.completed', true);
            },
            'users'
        ])->get()->map(function ($course) {
            return [
                'course' => $course->title,
                'completion_rate' => $course->users_count > 0
                    ? ($course->completed_users_count / $course->users_count) * 100
                    : 0
            ];
        });

        // Fetch engagement metrics
        $engagementMetrics = Course::with(['engagements' => function ($query) {
            $query->selectRaw('course_id, AVG(time_spent) as avg_time_spent, AVG(interactions) as avg_interactions, AVG(assignments_completed) as avg_assignments_completed')
                ->groupBy('course_id');
        }])
            ->get()
            ->map(function ($course) {
                return [
                    'course' => $course->title,
                    'avg_time_spent' => $course->engagements->first()->avg_time_spent ?? 0,
                    'avg_interactions' => $course->engagements->first()->avg_interactions ?? 0,
                    'avg_assignments_completed' => $course->engagements->first()->avg_assignments_completed ?? 0,
                ];
            });

        return response()->json([
            'popular_courses' => $popularCourses,
            'completion_rates' => $completionRates,
            'engagement_metrics' => $engagementMetrics
        ]);
    }









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
