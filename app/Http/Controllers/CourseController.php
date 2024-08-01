<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
        // Check if the user has the 'teacher' role
        if (!Gate::allows('create-course', $request->user())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            // Add more validation rules as needed
        ]);

        // Create course
        $course = Course::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'creator_id' => $request->user()->id, // Assuming the 'creator_id' field exists
        ]);

        return response()->json($course, 201);
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

