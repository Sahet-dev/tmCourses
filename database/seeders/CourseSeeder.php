<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course = Course::create([
            'title' => 'Sample Course',
            'description' => 'This is a sample course.',
            'thumbnail' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQw4xRGnWYYptD0a-NuAaWIteaeO9L0oCh7Ag&s',
            'price' => 49.99,
        ]);

        $lessons = [
            [
                'title' => 'Lesson 1',
                'video_url' => 'https://example.com/video1.mp4',
                'markdown_text' => '### Lesson 1 Content',
                'course_id' => $course->id,
            ],
            [
                'title' => 'Lesson 2',
                'video_url' => 'https://example.com/video2.mp4',
                'markdown_text' => '### Lesson 2 Content',
                'course_id' => $course->id,
            ],
        ];

        foreach ($lessons as $lesson) {
            Lesson::create($lesson);
        }
    }
}
