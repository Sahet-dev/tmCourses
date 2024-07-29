<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('lessons')->get();
        return Inertia::render('CourseCatalog', [
            'courses' => $courses,
        ]);
    }

    public function show($id)
    {
        $course = Course::with('lessons')->findOrFail($id);
        return Inertia::render('CourseDetail', [
            'course' => $course,
        ]);
    }

    // API methods for admin
    public function store(Request $request)
    {
        // Store logic
    }

    public function update(Request $request, $id)
    {
        // Update logic
    }

    public function destroy($id)
    {
        // Delete logic
    }
}

