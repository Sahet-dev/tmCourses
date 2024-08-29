<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class HomeController
{



    public function search(Request $request)
    {
        // Get the search term from the request
        $search = $request->input('search');

        // Fetch courses, filtering by the search term if provided
        $courses = Course::when($search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })->get();

        // Pass the courses and search term to the frontend via Inertia
        return Inertia::render('CourseCatalog', [
            'courses' => $courses,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }



    public function index(Request $request)
    {
        $search = $request->input('search', '');

        // Fields to select
        $fields = ['id', 'title', 'description', 'thumbnail', 'price'];

        // Query to fetch all courses (both general and premium)
        $coursesQuery = Course::select($fields);

        // Apply search filter if provided
        if ($search) {
            $coursesQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Get all courses
        $courses = $coursesQuery->get();

        // Render the view with the courses
        return Inertia::render('CourseCatalog', [
            'courses' => $courses,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }



    public function show($id, Course $course, Request $request)
    {
        // Fetch the course with all lessons
        $course = Course::with('lessons')->findOrFail($id);
        $user = $request->user();

        // Check if the course is premium and if the user has access
        if ($course->premium) {
            if (!$user || (!$course->subscription_access && !$user->hasPurchasedCourse($course))) {
                return redirect()->route('courses.index')->with('error', 'You do not have access to this course.');
            }
        }

        // Separate lessons into detailed and title-only
        $detailedLessons = $course->lessons->take(4); // First 4 lessons with full details
        $titleOnlyLessons = $course->lessons->skip(4); // Remaining lessons with only titles

        return Inertia::render('CourseDetail', [
            'course' => $course,
            'detailedLessons' => $detailedLessons,
            'titleOnlyLessons' => $titleOnlyLessons,
        ]);
    }

    public function main(Request $request)
    {
        // Fetch top 4 popular courses based on the total time spent by users on each course
        $popularCourses = Course::withCount(['engagements as total_engagement' => function ($query) {
            $query->select(DB::raw('SUM(time_spent)'));  // Summing up the time spent
        }])
            ->orderByDesc('total_engagement')  // Order by engagement
            ->take(4)
            ->get(['id', 'title', 'description', 'thumbnail', 'price']);

        // Get 3 sample comments for testimonials (mocked here, but should be from a model)
        $comments = [
            ['id' => 1, 'text' => 'This course was life-changing!', 'author' => 'John Doe'],
            ['id' => 2, 'text' => 'I learned so much in just a few days.', 'author' => 'Jane Smith'],
            ['id' => 3, 'text' => 'Highly recommend this to everyone!', 'author' => 'Sam Lee'],
        ];

        return Inertia::render('MainPage', [
            'popularCourses' => $popularCourses,
            'comments' => $comments,
        ]);
    }

    public function notificationsPage()
    {
        $notifications = [
            [
                'id' => 1,
                'title' => 'New Comment on Your Post',
                'message' => 'Someone commented on your post. Check it out!',
                'date' => now()->format('Y-m-d H:i'),
            ],
            [
                'id' => 2,
                'title' => 'System Update Available',
                'message' => 'A new system update is available. Please update your system.',
                'date' => now()->subDay()->format('Y-m-d H:i'),
            ],[
                'id' => 2,
                'title' => 'System Update Available',
                'message' => 'A new system update is available. Please update your system.',
                'date' => now()->subDay()->format('Y-m-d H:i'),
            ],[
                'id' => 2,
                'title' => 'System Update Available',
                'message' => 'A new system update is available. Please update your system.',
                'date' => now()->subDay()->format('Y-m-d H:i'),
            ],[
                'id' => 2,
                'title' => 'System Update Available',
                'message' => 'A new system update is available. Please update your system.',
                'date' => now()->subDay()->format('Y-m-d H:i'),
            ],
        ];

        // Return Inertia response with data
        return Inertia::render('NotificationsPage', [
            'notifications' => $notifications,
        ]);
    }

    public function showAccount()
    {
        $dummyData = [
            'user' => [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'created_at' => '2024-08-28',
            ],
            'accountDetails' => [
                'plan' => 'Pro',
                'expires_at' => '2024-12-31',
                'last_payment' => '2024-07-25',
            ],
        ];

        // Render the Account.vue component with Inertia and pass the dummy data
        return Inertia::render('Account', [
            'user' => $dummyData['user'],
            'accountDetails' => $dummyData['accountDetails'],
        ]);
    }

    public function completed()
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

        return Inertia::render('Completed', [
            'completedCourses' => $completedCourses,
        ]);
    }

    public function bookmarks()
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

        return Inertia::render('Bookmarks', [
            'bookmarkedItems' => $bookmarkedItems,
        ]);
    }


    public function activity()
    {
        // Dummy data for the Activity page
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

        return Inertia::render('Activity', [
            'activities' => $activities,
        ]);
    }


    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'boolean',
        ]);

        // Attempt to log the user in
        if (!Auth::attempt($request->only('email', 'password'), $request->remember)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        // Generate a token for the user
        $token = $user->createToken('API Token')->plainTextToken;

        // Return a JSON response with user details and token
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }


}
