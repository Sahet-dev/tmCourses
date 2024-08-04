<?php

namespace App\Http\Controllers;

use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
}
