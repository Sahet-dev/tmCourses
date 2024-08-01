<template>
    <div>
        <DashboardHeader @logout="handleLogout" />
        <div class="flex">
            <AdminSidebar :role="user.role" />
            <main class="flex-1 p-6">
                <!-- Conditionally render dashboards based on user role -->
                <AdminDashboard v-if="user.role === 'admin'" />
                <CourseCreatorDashboard v-if="user.role === 'teacher'" />
                <ModeratorDashboard v-if="user.role === 'moderator'" />
                <div class="text-red-500" v-if="errorMessage">{{ errorMessage }}</div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import apiClient from '../api/axios'; // Ensure this path is correct
import DashboardHeader from "../components/DashboardHeader.vue";
import AdminSidebar from "../components/AdminSidebar.vue";
import AdminDashboard from '../components/AdminDashboard.vue';
import CourseCreatorDashboard from '../components/CourseCreatorDashboard.vue';
import ModeratorDashboard from '../components/ModeratorDashboard.vue';
import {useRouter} from "vue-router";

const user = ref({});
const errorMessage = ref('');

const fetchUser = async () => {
    try {
        const response = await apiClient.get('/user');
        user.value = response.data;
    } catch (error) {
        console.error('Failed to fetch user data:', error);
        errorMessage.value = 'Failed to fetch user data.';
        // Assuming useRouter is available, replace this with correct redirect logic
        useRouter().push('/login');
    }
};

const handleLogout = async () => {
    try {
        console.log('Attempting to logout...'); // Log before request
        const response = await apiClient.post('/logout');
        console.log('Logout response:', response.data); // Debugging
        localStorage.removeItem('token');
        router.push({name: 'login'})
    } catch (error) {
        console.error('Failed to logout:', error);
        if (error.response) {
            console.error('Response status:', error.response.status); // Log response status
            console.error('Response data:', error.response.data); // Log response data
        }
        errorMessage.value = error.response?.data?.message || 'Failed to logout.';
    }
};

onMounted(fetchUser);
</script>

<style scoped>
/* Dashboard styles */
</style>
