<template>
    <div>
        <h1>Courses</h1>
        <div v-if="error">{{ error }}</div>
        <div v-if="courses.length > 0">
            <div v-for="course in courses" :key="course.id" class="course-card">
                <h2>{{ course.title }}</h2>
                <p>{{ course.description }}</p>
                <img :src="`/storage/${course.thumbnail}`" alt="Course Thumbnail" />
                <p>Price: ${{ course.price }}</p>
            </div>
        </div>

        <div v-else class="text-center text-gray-500">  No courses found.</div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import apiClient from '../api/axios';

const courses = ref([]);

const fetchCourses = async () => {
    try {
        const response = await apiClient.get('/teacher/courses');
        courses.value = response.data.data;
        console.log(courses.value)
    } catch (error) {
        console.error('Failed to fetch courses:', error);
    }
};

onMounted(fetchCourses);
</script>

<style scoped>
/* Add your styles here */
</style>
