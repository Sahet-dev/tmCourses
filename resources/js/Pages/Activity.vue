<template>
    <div class="max-w-2xl mx-auto p-4 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-bold mb-4">Activity Log</h1>
        <div v-if="loading" class="text-center">
            <Loader />
        </div>
        <div v-else>
            <ul class="space-y-2">
                <li v-for="activity in activities" :key="activity.id" class="p-4 border-b border-gray-200">
                    <p class="text-sm font-medium">{{ activity.action }}</p>
                    <p class="text-xs text-gray-500">{{ activity.date }}</p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import apiClient from "@/axios.js";
import Loader from "@/Pages/components/Loader.vue"; // Adjust the path as needed


const activities = ref([]);
const loading = ref(true);

const fetchData = async () => {
    try {
        const response = await apiClient.get('/activity');
        activities.value = response.data.activities;
    } catch (error) {
        console.error('Error fetching activity data:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchData();
});
</script>

<style scoped>
/* Add any custom styles you want for the Activity page */
</style>
