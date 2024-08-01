<template>
    <div v-if="courseId">
        <form @submit.prevent="createLesson">
            <!-- Lesson Title -->
            <div class="mb-4">
                <label for="lesson-title" class="block text-gray-700">Lesson Title</label>
                <input v-model="lesson.title" id="lesson-title" type="text" class="w-full px-3 py-2 border rounded" required />
            </div>

            <!-- Video URL -->
            <div class="mb-4">
                <label for="video-url" class="block text-gray-700">Video URL</label>
                <input v-model="lesson.video_url" id="video-url" type="text" class="w-full px-3 py-2 border rounded" required />
            </div>

            <!-- Markdown Text -->
            <div class="mb-4">
                <label for="markdown-text" class="block text-gray-700">Lesson Content (Markdown)</label>
                <textarea v-model="lesson.markdown_text" id="markdown-text" class="w-full px-3 py-2 border rounded" required></textarea>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Lesson</button>
            <div v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</div>
        </form>
    </div>
</template>

<script setup>
import { ref, defineProps } from 'vue';
import apiClient from "../../api/axios.js"; // Adjust path if needed

const props = defineProps(['courseId']);
const lesson = ref({
    title: '',
    video_url: '',
    markdown_text: ''
});
const errorMessage = ref('');

const createLesson = async () => {
    try {
        await apiClient.post(`/courses/${props.courseId}/lessons`, lesson.value);
        lesson.value = { title: '', video_url: '', markdown_text: '' }; // Clear form
        errorMessage.value = '';
        // Optionally refresh lesson list
    } catch (error) {
        console.error('Failed to create lesson:', error);
        errorMessage.value = 'Failed to create lesson.';
    }
};
</script>

<style scoped>
/* Lesson Management Form styles */
</style>
