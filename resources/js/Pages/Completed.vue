<template>
    <div class="max-w-2xl mx-auto p-4 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-bold mb-4">Completed Courses</h1>
        <div v-if="loading" class="text-center">
            <Loader />
        </div>
        <div v-else>
            <ul class="space-y-2">
                <li v-for="course in completedCourses" :key="course.id" class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">{{ course.title }}</h2>
                    <p class="text-sm text-gray-500">Completed on: {{ course.completed_at }}</p>
                    <p class="text-sm text-gray-500">Progress: {{ course.progress }}</p>
                    <p class="text-sm text-gray-500">Rating: {{ course.rating }}/5</p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import apiClient from "@/axios.js";
import Loader from "@/Pages/components/Loader.vue"; // Adjust the path as needed


const completedCourses = ref([]);
const loading = ref(true);

const fetchData = async () => {
    try {
        const response = await apiClient.get('/completed');
        completedCourses.value = response.data.completedCourses;
    } catch (error) {
        console.error('Error fetching completed courses:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchData();
});
</script>

<style scoped>
/* Add any custom styles you want for the Completed page */
</style>
