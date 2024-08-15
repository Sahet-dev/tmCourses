<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class LessonController extends Controller
{
    public function store(Request $request, $courseId)
    {
        if (!Gate::allows('create', Lesson::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'markdown_text' => 'required|string',
        ]);

        $lesson = Lesson::create([
            'course_id' => $courseId,
            'title' => $validated['title'],
            'video_url' => $validated['video_url'],
            'markdown_text' => $validated['markdown_text'],
        ]);

        return new LessonResource($lesson);
    }



    public function update(Request $request, $id)
    {
        // Debugging: Log all incoming request data
        Log::info('Request data:', $request->all());

        $lesson = Lesson::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'markdown_text' => 'nullable|string',
            'video_url' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:20480',
        ]);

        // Update lesson data
        $lesson->update($validatedData);

        // Handle video file separately if uploaded
        if ($request->hasFile('video_url')) {
            $videoPath = $request->file('video_url')->store('videos', 'public');
            $lesson->update(['video_url' => $videoPath]);
        }

        return response()->json(['message' => 'Lesson updated successfully', 'lesson' => $lesson]);
    }





    public function fetchLessons($id)
    {
        $course = Course::with('lessons')->findOrFail($id);
        return response()->json(['lessons' => $course->lessons]);
    }


}
