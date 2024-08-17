<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
        $course = Course::with('lessons')->find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return response()->json([
            'course' => $course,
            'lessons' => $course->lessons
        ]);
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
        Log::info('Update Request Data:', $request->all());
        // Validate the input fields
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Find the course by ID
        $course = Course::find($id);
        if (!$course) {
            return response()->json(['message' => 'Course not found.'], 404);
        }

        // Update course fields
        $course->title = $request->input('title');
        $course->description = $request->input('description');
        $course->price = $request->input('price');

        // Handle thumbnail update
        if ($request->hasFile('thumbnail')) {
            $course->thumbnail = $request->file('thumbnail')->store('thumbnails');
        }

        // Save the updated course
        $course->save();

        return response()->json(['message' => 'Course updated successfully.']);
    }









    public function destroy($id)
    {
        // Check if the user has one of the required roles
        if (!Auth::user()->hasRole(['admin', 'moderator', 'teacher'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Find the course by ID
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // Delete associated lessons
        $lessons = $course->lessons;
        foreach ($lessons as $lesson) {
            // Optionally delete video files from storage
            if (Storage::disk('public')->exists($lesson->video_url)) {
                Storage::disk('public')->delete($lesson->video_url);
            }
            $lesson->delete();
        }

        // Optionally delete thumbnail file from storage
        if (Storage::disk('public')->exists($course->thumbnail)) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        // Delete the course
        $course->delete();

        return response()->json(['message' => 'Course and associated lessons deleted successfully.']);
    }




}

