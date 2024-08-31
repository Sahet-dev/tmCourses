<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudentCourseController extends Controller
{
    /**
     * Display the specified course for students.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $course = Course::find($id);

        if (!$course) {
            abort(404);
        }

        return Inertia::render('CourseDetail', [
            'course' => $course
        ]);
    }



    public function showAccount(): JsonResponse
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Fetch user data and related subscriptions
        $accountDetails = $user->subscriptions()
            ->where('status', 'active') // Assuming the subscription table has 'status' column
            ->select('plan', 'expires_at', 'last_payment') // Adjust these fields as per your Subscription table
            ->first(); // Fetch the first active subscription

        // Check if there is no active subscription
        $accountDetails = $accountDetails ?? [
            'plan' => 'None',
            'expires_at' => null,
            'last_payment' => null,
        ];

        $data = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format('Y-m-d'),
            ],
            'accountDetails' => [
                'plan' => $accountDetails->plan ?? 'Free', // Default to 'Free' if no subscription exists
                'expires_at' => $accountDetails->expires_at ?? 'N/A',
                'last_payment' => $accountDetails->last_payment ?? 'N/A',
            ],
        ];

        return response()->json($data);
    }

    public function completed(): JsonResponse
    {
        $completedCourses = [
            [
                'id' => 1,
                'title' => 'Introduction to Laravel',
                'completed_at' => '2024-08-01',
                'progress' => '100%',
                'rating' => 5,
            ],
            [
                'id' => 2,
                'title' => 'Advanced Vue.js Techniques',
                'completed_at' => '2024-08-15',
                'progress' => '100%',
                'rating' => 4,
            ],
            [
                'id' => 3,
                'title' => 'Building REST APIs with PHP',
                'completed_at' => '2024-08-22',
                'progress' => '100%',
                'rating' => 5,
            ],
        ];

        return response()->json(['completedCourses' => $completedCourses]);
    }

    public function bookmarks(): JsonResponse
    {
        $bookmarkedItems = [
            [
                'id' => 1,
                'title' => 'Vue.js for Beginners',
                'type' => 'Course',
                'bookmarked_at' => '2024-08-05',
            ],
            [
                'id' => 2,
                'title' => 'Laravel Tips and Tricks',
                'type' => 'Article',
                'bookmarked_at' => '2024-08-10',
            ],
            [
                'id' => 3,
                'title' => 'Building APIs with Laravel',
                'type' => 'Video',
                'bookmarked_at' => '2024-08-20',
            ],
        ];

        return response()->json(['bookmarkedItems' => $bookmarkedItems]);
    }

    public function activity(): JsonResponse
    {
        $activities = [
            [
                'id' => 1,
                'action' => 'User logged in',
                'date' => '2024-08-25 10:30 AM',
            ],
            [
                'id' => 2,
                'action' => 'User completed a course: "Vue.js Basics"',
                'date' => '2024-08-24 03:45 PM',
            ],
            [
                'id' => 3,
                'action' => 'User bookmarked an article: "Laravel Tips and Tricks"',
                'date' => '2024-08-23 08:20 AM',
            ],
        ];

        return response()->json(['activities' => $activities]);
    }
}
