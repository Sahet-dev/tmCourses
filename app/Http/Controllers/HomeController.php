<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController
{
    public function index()
    {
        $courses = Course::with('lessons')->get();
        return Inertia::render('CourseCatalog', [
            'courses' => $courses,
        ]);
    }

//    public function show($id): \Inertia\Response
//    {
//        $course = Course::with('lessons')->findOrFail($id);
//        return Inertia::render('CourseDetail', [
//            'course' => $course,
//        ]);
//    }



    public function show($id)
    {
        // Fetch the course with its lessons
        $course = Course::with('lessons')->findOrFail($id);

        // Pass the course data to the Vue component
        return Inertia::render('CourseDetail', [
            'course' => $course,
        ]);
    }
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



}
