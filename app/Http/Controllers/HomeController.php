<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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



}
