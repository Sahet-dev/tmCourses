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
    public function store(Request $request, Course $course)
    {
        // Validate incoming request data
        $request->validate([
            'title' => 'nullable|string|max:255',
            'video_url' => 'nullable|mimes:mp4,mov,avi,mpg,wmv|max:10000',
            'markdown_text' => 'nullable|string',
        ]);

        // Create a new Lesson instance
        $lesson = new Lesson();

        // Assign course_id from the Course instance
        $lesson->course_id = $course->id;

        // Assign other attributes with default values if not provided
        $lesson->title = $request->input('title', 'Default Title');
        $lesson->markdown_text = $request->input('markdown_text', 'Default Markdown Text');

        // Handle video upload
        if ($request->hasFile('video_url')) {
            $lesson->video_url = $request->file('video_url')->store('videos', 'public');
        } else {
            $lesson->video_url = 'default_video.mp4'; // Default video URL if no file is uploaded
        }

        // Save the lesson to the course
        $course->lessons()->save($lesson);

        // Return a JSON response with the created lesson
        return response()->json(['lesson' => $lesson], 201);
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
