<template>
    <div class="max-w-2xl mx-auto p-4 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-bold mb-4">Bookmarked Items</h1>
        <div v-if="loading" class="text-center">
            <Loader />
        </div>
        <div v-else>
            <ul class="space-y-2">
                <li v-for="item in bookmarkedItems" :key="item.id" class="p-4 border-b border-gray-200">
                    <p class="text-sm font-medium">{{ item.title }}</p>
                    <p class="text-xs text-gray-500">Type: {{ item.type }}</p>
                    <p class="text-xs text-gray-400">Bookmarked at: {{ item.bookmarked_at }}</p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import apiClient from "@/axios.js";
import Loader from "@/Pages/components/Loader.vue"; // Adjust the path as needed


const bookmarkedItems = ref([]);
const loading = ref(true);

const fetchData = async () => {
    try {
        const response = await apiClient.get('/bookmarks');
        bookmarkedItems.value = response.data.bookmarkedItems;
    } catch (error) {
        console.error('Error fetching bookmarked items:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchData();
});
</script>

<style scoped>
/* Add any custom styles you want for the Bookmarks page */
</style>
