<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    public function index()
    {

        $courses = Course::all();
        return CourseResource::collection($courses);
    }

    public function show($id): JsonResponse
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return response()->json($course, 200);
    }

    // API methods for admin
    public function store(Request $request)
    {
        // Check if the user has one of the required roles
        if (!Auth::user()->hasRole(['admin', 'moderator', 'teacher'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'lessons' => 'required|array',
            'lessons.*.title' => 'required|string|max:255',
            'lessons.*.video_url' => 'required|file|mimetypes:video/mp4,video/x-m4v,video/*',
            'lessons.*.markdown_text' => 'required|string',
        ]);

        // Handle thumbnail upload
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');

        // Create the course
        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'price' => $request->price,
            'teacher_id' => auth()->id(),
        ]);

        // Create the lessons
        foreach ($request->lessons as $lesson) {
            $videoPath = $lesson['video_url']->store('videos', 'public');

            Lesson::create([
                'course_id' => $course->id,
                'title' => $lesson['title'],
                'video_url' => $videoPath,
                'markdown_text' => $lesson['markdown_text'],
            ]);
        }

        return response()->json(['id' => $course->id], 201);
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

