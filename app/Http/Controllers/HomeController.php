<?php

namespace App\Http\Controllers;

use App\Models\Course;
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



}
