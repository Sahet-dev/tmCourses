<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">Course Creator Dashboard</h1>

        <!-- Course Creation Form -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Create a New Course</h2>
            <CourseCreationForm />
        </div>

        <!-- Lesson Management Form -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold mb-2">Manage Lessons</h2>
            <!-- Assuming you have a list of courses available as `courses` -->
            <LessonManagementForm :course-id="selectedCourseId" />
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import CourseCreationForm from "./Course/CourseCreationForm.vue";
import LessonManagementForm from './Course/LessonManagementForm.vue';

// You might have a list of courses and a way to select one
const selectedCourseId = ref(null); // This should be dynamically set based on user selection

// Example data fetching function (assuming you have courses data)
const fetchCourses = async () => {
    try {
        // Fetch courses data here and update `courses` data
    } catch (error) {
        console.error('Failed to fetch courses:', error);
    }
};

// Call fetchCourses() or other setup logic as needed
</script>

<style scoped>
/* Dashboard styles */
</style>
