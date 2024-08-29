<template>
    <div>
        <Navbar />
        <div class="min-h-screen bg-gradient-to-r from-gray-100 via-pink-50 to-blue-50 ">
            <header class="bg-gradient-to-r from-blue-200 via-purple-100 to-pink-200 shadow-md">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
                </div>
            </header>

            <main>
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 ">
                    <!-- Notification List -->
                        <div class="">
                            <ul role="list" class="divide-y divide-gray-200 ">
                                <li v-for="notification in notifications" :key="notification.id" class="p-4 mb-2 flex items-center space-x-4 bg-white shadow rounded-md   divide-gray-200 animate-element">
                                    <div class="flex-shrink-0">
                                        <svg class="h-10 w-10 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M11 1a1 1 0 011 1v3.293a1 1 0 01-.293.707l-1.707 1.707-1.707-1.707A1 1 0 019 5.293V2a1 1 0 011-1zM1 10a1 1 0 011-1h5.586l1.707-1.707A2 2 0 0111 7V6a2 2 0 00-2-2H3a1 1 0 01-1-1zm13 4a1 1 0 01-.707-1.707l1.707-1.707A2 2 0 0018 9h1a1 1 0 011 1v4a1 1 0 01-1 1h-1a2 2 0 00-1.293-.707l-1.707 1.707A1 1 0 0114 14z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ notification.title }}</p>
                                        <p class="text-sm text-gray-500">{{ notification.message }}</p>
                                        <p class="text-xs text-gray-400">{{ notification.date }}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button @click="markAsRead(notification.id)" class="text-indigo-600 hover:text-indigo-800 text-sm">Mark as read</button>
                                    </div>
                                </li>
                                <!-- Add more notification items as needed -->
                            </ul>
                        </div>
                </div>
            </main>
        </div>

    </div>
</template>


<script setup>

import {defineProps, onMounted} from 'vue';
import Navbar from "@/Pages/Navbar.vue";
import { beforeEnterEl, enterEl, lenis } from '@/utils/animations';



// Define props
const props = defineProps(
    {notifications: Array,}
);
const notifications = props.notifications;



function markAsRead(id) {
    // Logic to mark notification as read
    console.log(`Notification ${id} marked as read`);
}

onMounted(() => {
    const elements = document.querySelectorAll('.animate-element');

    elements.forEach((el, index) => {
        // Trigger animations for each element with staggered delay
        beforeEnterEl(el);
        enterEl(el, () => {
            // console.log('Animation complete');
        }, index);  // Pass the index for staggered delay
    });

    // Lenis scroll usage if needed
    lenis.on('scroll', (e) => {
        // console.log('Scrolled:', e);
    });
});
</script>

<style scoped>
</style>
