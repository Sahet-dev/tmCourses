<template>
    <div>
        <Navbar />
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-6">Course Catalog</h1>
            <div v-if="courses.length">
                <div v-for="course in courses" :key="course.id" class="bg-white rounded shadow p-6 mb-6">
                    <img
                        :src="imageUrl(course.thumbnail)"
                        :alt="course.title"
                        class="w-full h-48 object-cover rounded mb-4"
                    />
                    <h2 class="text-xl font-semibold mb-2" v-html="highlight(course.title)"></h2>
                    <p class="text-gray-700 mb-2" v-html="highlight(course.description)"></p>
                    <p class="text-lg font-bold mb-2">${{ course.price }}</p>
                    <a
                        :href="route('courseDetail', course.id)"
                        class="text-blue-500 hover:underline"
                    >View Course</a>
                </div>
            </div>
            <div v-else class="text-gray-500">
                No courses found matching the search criteria.
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed} from 'vue';
import Navbar from '@/Pages/Navbar.vue';
import {usePage} from '@inertiajs/vue3';

// Get the props from the server using usePage
const {props} = usePage();

// Function to generate the course image URL
const imageUrl = (thumbnail) => {
    const baseUrl = import.meta.env.VITE_APP_URL || 'http://localhost:8000';
    return `${baseUrl}/storage/${thumbnail}`;
};

// Function to highlight the search term
const highlight = (text) => {
    const search = props.filters?.search || ''; // Get search term from props
    if (!search) return text; // If no search term, return original text

    const regex = new RegExp(`(${search})`, 'gi');
    return text.replace(regex, '<span class="bg-yellow-200">$1</span>');
};

// Computed property for courses
const courses = computed(() => props.courses);
</script>

<style scoped>
/* Add any styles here */
</style>
