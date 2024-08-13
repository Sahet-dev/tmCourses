<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentCourseController extends Controller
{
    /**
     * Display the specified course for students.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $course = Course::find($id);

        if (!$course) {
            abort(404);
        }

        return Inertia::render('CourseDetail', [
            'course' => $course
        ]);
    }
}
