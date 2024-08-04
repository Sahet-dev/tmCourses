<template>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-md shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Course and Add First Lesson</h2>
        <form @submit.prevent="createCourseAndAddLesson" enctype="multipart/form-data">
            <!-- Course Form -->
            <div class="mb-4">
                <label for="title" class="block text-lg font-medium text-gray-700">Course Title</label>
                <input v-model="course.title" id="title" type="text" class="w-full px-3 py-2 border rounded-md" required />
            </div>
            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-gray-700">Course Description</label>
                <textarea v-model="course.description" id="description" class="w-full px-3 py-2 border rounded-md" required></textarea>
            </div>
            <div class="mb-4">
                <label for="thumbnail" class="block text-lg font-medium text-gray-700">Course Thumbnail</label>
                <input @change="handleFileUpload" id="thumbnail" type="file" class="w-full px-3 py-2 border rounded-md" required />
                <img v-if="thumbnailPreview" :src="thumbnailPreview" alt="Thumbnail Preview" class="mt-2 w-32 h-32 object-cover" />
            </div>
            <div class="mb-4">
                <label for="price" class="block text-lg font-medium text-gray-700">Price</label>
                <input v-model="course.price" id="price" type="number" step="0.01" class="w-full px-3 py-2 border rounded-md" required />
            </div>

            <!-- Lesson Form -->
            <div class="mb-4">
                <label for="lessonTitle" class="block text-lg font-medium text-gray-700">Lesson Title</label>
                <input v-model="lesson.title" id="lessonTitle" type="text" class="w-full px-3 py-2 border rounded-md" required />
            </div>
            <div class="mb-4">
                <label for="video_url" class="block text-lg font-medium text-gray-700">Video URL</label>
                <input v-model="lesson.video_url" id="video_url" type="url" class="w-full px-3 py-2 border rounded-md" required />
            </div>
            <div class="mb-4">
                <label for="markdown_text" class="block text-lg font-medium text-gray-700">Markdown Text</label>
                <textarea v-model="lesson.markdown_text" id="markdown_text" rows="4" class="w-full px-3 py-2 border rounded-md" required></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600">Create Course and Add Lesson</button>
            <div v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</div>
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
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import apiClient from "../../api/axios.js"; // Adjust path if needed

const router = useRouter();
const course = ref({
    title: '',
    description: '',
    thumbnail: null,
    price: 0
});
const lesson = ref({
    title: '',
    video_url: '',
    markdown_text: '',
});
const lessons = ref([]);
const error = ref('');
const errorMessage = ref('');
const thumbnailPreview = ref(null);
const courseCreated = ref(false);
const courseId = ref(null);

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        course.value.thumbnail = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            thumbnailPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const createCourseAndAddLesson = async () => {
    const formData = new FormData();
    formData.append('title', course.value.title);
    formData.append('description', course.value.description);
    formData.append('price', course.value.price);
    formData.append('thumbnail', course.value.thumbnail); // Append the file

    // Append lesson data
    formData.append('lesson_title', lesson.value.title);
    formData.append('lesson_video_url', lesson.value.video_url);
    formData.append('lesson_markdown_text', lesson.value.markdown_text);

    try {
        const response = await apiClient.post('/courses', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        course.value = { title: '', description: '', thumbnail: null, price: 0 }; // Clear form
        lesson.value = { title: '', video_url: '', markdown_text: '' }; // Clear lesson form
        thumbnailPreview.value = null; // Clear thumbnail preview
        errorMessage.value = '';

        // Optionally redirect or show success message
        router.push(`/course/${response.data.id}/add-lesson`);
    } catch (error) {
        console.error('Failed to create course:', error);
        errorMessage.value = 'Failed to create course.';
    }
};

</script>

<style scoped>
/* Course Creation Form styles */
</style>
