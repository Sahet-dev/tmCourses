<template>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Create a New Course</h2>
        <form @submit.prevent="submitCourseForm">
            <div class="mb-4">
                <label for="courseTitle" class="block text-sm font-medium text-gray-700">Course Title</label>
                <input type="text" id="courseTitle" v-model="course.title" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="courseDescription" class="block text-sm font-medium text-gray-700">Course Description</label>
                <textarea id="courseDescription" v-model="course.description" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>
            <div class="mb-4">
                <label for="coursePrice" class="block text-sm font-medium text-gray-700">Course Price</label>
                <input type="number" id="coursePrice" v-model="course.price" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="courseImage" class="block text-sm font-medium text-gray-700">Course Image</label>
                <input type="file" id="courseImage" @change="handleImageUpload" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="courseCategory" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="courseCategory" v-model="course.category" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700">Create Course</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const course = ref({
    title: '',
    description: '',
    price: 0,
    category: '',
})

const categories = ref([
    { id: 1, name: 'Programming' },
    { id: 2, name: 'Design' },
    { id: 3, name: 'Marketing' },
])

const submitCourseForm = () => {
    // Submit course form logic
}

const handleImageUpload = (event) => {
    const file = event.target.files[0]
    // Handle image upload logic
}
</script>

<style scoped>
/* Add any additional styles here */
</style>
