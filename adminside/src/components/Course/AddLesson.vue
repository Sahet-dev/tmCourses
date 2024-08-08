<template>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <!-- Display Course Details -->
        <div class="mb-6 flex items-center space-x-4">
            <img
                v-if="course.thumbnail"
                :src="thumbnailUrl"
                alt="Course Thumbnail"
                class="w-24 h-24 object-cover rounded-md shadow-sm"
            />
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">{{ course.title }}</h2>
                <p class="text-gray-600 mt-1">{{ course.description }}</p>
            </div>
        </div>

        <!-- Add Lesson Form -->
        <form @submit.prevent="addLesson" class="space-y-6">
            <div>
                <label for="title" class="block text-lg font-medium text-gray-700 mb-2">Lesson Title:</label>
                <input
                    v-model="lesson.title"
                    id="title"
                    type="text"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div>
                <label for="video_url" class="block text-lg font-medium text-gray-700 mb-2">Video URL:</label>
                <input
                    v-model="lesson.video_url"
                    id="video_url"
                    type="url"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div>
                <label for="markdown_text" class="block text-lg font-medium text-gray-700 mb-2">Markdown Text:</label>
                <textarea
                    v-model="lesson.markdown_text"
                    id="markdown_text"
                    required
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
            </div>
            <button
                type="submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Add Lesson
            </button>
        </form>

        <!-- Display Existing Lessons -->
        <div v-if="lessons.length > 0" class="mt-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Existing Lessons</h3>
            <ul class="space-y-4">
                <li v-for="lesson in lessons" :key="lesson.id" class="p-4 border border-gray-300 rounded-md shadow-sm">
                    <h4 class="text-lg font-medium text-gray-800">{{ lesson.title }}</h4>
                    <p class="text-gray-600 mt-1">{{ lesson.video_url }}</p>
                    <p class="text-gray-600 mt-1">{{ lesson.markdown_text }}</p>
                </li>
            </ul>
        </div>

        <!-- Error Message -->
        <div v-if="error" class="mt-4 text-red-600">
            {{ error }}
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import apiClient from "../../api/axios.js"; // Adjust path if needed
import Ckeditor from '../Ceditor.vue';

const route = useRoute(); // Access route parameters
const courseId = route.params.id; // Get course ID from route
const course = ref({
    title: '',
    description: '',
    thumbnail: '',
});
const lesson = ref({
    title: '',
    video_url: '',
    markdown_text: '',
});
const lessons = ref([]);
const error = ref('');

// Fetch course details and lessons when component is mounted
onMounted(async () => {
    try {
        // Fetch course details
        const courseResponse = await apiClient.get(`/courses/${courseId}`);
        course.value = courseResponse.data;

        // Log the fetched course details to debug
        console.log('Course details:', course.value);

        // Fetch existing lessons
        const lessonsResponse = await apiClient.get(`/courses/${courseId}/lessons`);
        lessons.value = lessonsResponse.data;
    } catch (err) {
        console.error('Failed to fetch course or lessons:', err);
        error.value = 'Failed to fetch course or lessons.';
    }
});

const thumbnailUrl = computed(() => {
    console.log('Thumbnail path:', course.value.thumbnail);
    return course.value.thumbnail
        ? `http://localhost:8000/storage/thumbnails/${course.value.thumbnail}`
        : '';

});


// Computed property for the thumbnail URL
// const thumbnailUrl = computed(() => {
//     if (course.value.thumbnail) {
//         const baseUrl = import.meta.env.VITE_APP_URL;
//         console.log('Base URL:', baseUrl);
//         console.log('Thumbnail path:', course.value.thumbnail);
//         return `${baseUrl}/storage/thumbnails/${course.value.thumbnail}`;
//     }
//     return '';
// });

// Log thumbnail URL to verify
console.log(thumbnailUrl.value);

const addLesson = async () => {
    try {
        await apiClient.post(`/courses/${courseId}/lessons`, lesson.value);
        lesson.value = { title: '', video_url: '', markdown_text: '' }; // Clear form
        error.value = '';

        // Refresh the list of lessons
        const lessonsResponse = await apiClient.get(`/courses/${courseId}/lessons`);
        lessons.value = lessonsResponse.data;
    } catch (err) {
        console.error('Failed to add lesson:', err);
        error.value = 'Failed to add lesson.';
    }
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
