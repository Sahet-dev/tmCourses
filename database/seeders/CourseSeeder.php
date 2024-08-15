<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Path to the existing thumbnail and video
        $thumbnailPath = 'thumbnails/8PloiWZ9Nb70rH41ieEc8Fwc5ALkA7roWRun2uzd.png';
        $videoPath = 'videos/U8MTPc2G7JNUaA9ngkHC1tOf9GxUGccJHw85daG0.mp4';

        // Seed multiple courses
        for ($i = 1; $i <= 5; $i++) {

            // Create the course using the existing thumbnail
            $course = Course::create([
                'title' => 'Course Title ' . $i,
                'description' => 'This is a description for course ' . $i,
                'thumbnail' => $thumbnailPath, // Use the existing thumbnail path
                'price' => rand(10, 100),
                'teacher_id' => 1, // Assuming you have a teacher with ID 1
            ]);

            // Seed lessons for each course
            for ($j = 1; $j <= rand(3, 7); $j++) {

                // Create the lesson using the existing video
                Lesson::create([
                    'course_id' => $course->id,
                    'title' => 'Lesson ' . $j . ' for Course ' . $i,
                    'video_url' => $videoPath, // Use the existing video path
                    'markdown_text' => '## Lesson ' . $j . ' Content for Course ' . $i . "\nThis is the markdown text.",
                ]);
            }
        }
    }
}
