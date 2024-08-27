<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function purchase(Course $course, Request $request)
    {
        $user = $request->user();

        if ($course->premium && !$user->hasPurchasedCourse($course)) {
            $user->courses()->attach($course->id, ['enrolled_at' => now()]);
            return redirect()->route('courses.show', $course)->with('success', 'Course purchased successfully.');
        }

        return redirect()->back()->with('error', 'You have already purchased this course or it is not for sale.');
    }
}
