<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
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
        if (!Gate::allows('create', Course::class)) {
            Log::error('Unauthorized access attempt to create a course', ['user_id' => $request->user()->id]);
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
        ]);

        // Store thumbnail
        $path = $request->file('thumbnail')->store('thumbnails', 'public');

        // Create course
        $course = Course::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'thumbnail' => $path,
            'price' => $validated['price'],
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

