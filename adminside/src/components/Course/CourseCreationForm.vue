<template>
    <div>
        <form @submit.prevent="createCourse" enctype="multipart/form-data">
            <!-- Course Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Course Title</label>
                <input v-model="course.title" id="title" type="text" class="w-full px-3 py-2 border rounded" required />
            </div>

            <!-- Course Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Course Description</label>
                <textarea v-model="course.description" id="description" class="w-full px-3 py-2 border rounded" required></textarea>
            </div>

            <!-- Thumbnail Upload -->
            <div class="mb-4">
                <label for="thumbnail" class="block text-gray-700">Course Thumbnail</label>
                <input @change="handleFileUpload" id="thumbnail" type="file" class="w-full px-3 py-2 border rounded" required />
                <img v-if="thumbnailPreview" :src="thumbnailPreview" alt="Thumbnail Preview" class="mt-2 w-32 h-32 object-cover"/>
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700">Price</label>
                <input v-model="course.price" id="price" type="number" step="0.01" class="w-full px-3 py-2 border rounded" required />
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Course</button>
            <div v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import apiClient from "../../api/axios.js"; // Adjust path if needed

const course = ref({
    title: '',
    description: '',
    thumbnail: null,
    price: 0
});
const errorMessage = ref('');
const thumbnailPreview = ref(null);

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

const createCourse = async () => {
    const formData = new FormData();
    formData.append('title', course.value.title);
    formData.append('description', course.value.description);
    formData.append('price', course.value.price);
    formData.append('thumbnail', course.value.thumbnail); // Append the file

    try {
        await apiClient.post('/courses', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        course.value = { title: '', description: '', thumbnail: null, price: 0 }; // Clear form
        thumbnailPreview.value = null; // Clear thumbnail preview
        errorMessage.value = '';
        // Optionally redirect or show success message
    } catch (error) {
        console.error('Failed to create course:', error);
        errorMessage.value = 'Failed to create course.';
    }
};
</script>

<style scoped>
/* Course Creation Form styles */
</style>
