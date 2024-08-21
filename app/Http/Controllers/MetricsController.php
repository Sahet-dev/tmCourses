<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Engagement;
use Illuminate\Http\Request;

class MetricsController extends Controller
{
//    public function index()
//    {
//        // Fetch all popular courses based on enrollments
//        $popularCourses = Course::withCount('users')
//            ->orderBy('users_count', 'desc')
//            ->take(5)
//            ->get();
//
//        // Fetch course completion rates
//        $completionRates = Course::withCount(['users as completed_users_count' => function ($query) {
//            $query->wherePivot('completed', true);
//        }])
//            ->withCount('users')
//            ->get()
//            ->map(function ($course) {
//                return [
//                    'course' => $course->title,
//                    'completion_rate' => ($course->completed_users_count / $course->users_count) * 100
//                ];
//            });
//
//        // Fetch engagement metrics
//        $engagementMetrics = Course::with(['engagements' => function ($query) {
//            $query->selectRaw('course_id, AVG(time_spent) as avg_time_spent, AVG(interactions) as avg_interactions, AVG(assignments_completed) as avg_assignments_completed')
//                ->groupBy('course_id');
//        }])
//            ->get()
//            ->map(function ($course) {
//                return [
//                    'course' => $course->title,
//                    'avg_time_spent' => $course->engagements->first()->avg_time_spent ?? 0,
//                    'avg_interactions' => $course->engagements->first()->avg_interactions ?? 0,
//                    'avg_assignments_completed' => $course->engagements->first()->avg_assignments_completed ?? 0,
//                ];
//            });
//
//        return response()->json([
//            'popular_courses' => $popularCourses,
//            'completion_rates' => $completionRates,
//            'engagement_metrics' => $engagementMetrics
//        ]);
//    }
}
