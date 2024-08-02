<template>
    <div>

        <DashboardHeader @logout="handleLogout" />
        <div class="flex">
            <AdminSidebar :role="user.role" />
            <main class="flex-1 p-6">
                <AdminDashboard v-if="user.role === 'admin'" />
                <CourseCreatorDashboard v-if="user.role === 'teacher'" />
                <ModeratorDashboard v-if="user.role === 'moderator'" />
                <div class="text-red-500" v-if="errorMessage">{{ errorMessage }}</div>
            </main>
            <div class="text-red-500 text-center">{{ user}} role</div>

        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import apiClient from '../api/axios';
import DashboardHeader from "../components/DashboardHeader.vue";
import AdminSidebar from "../components/AdminSidebar.vue";
import AdminDashboard from '../components/AdminDashboard.vue';
import CourseCreatorDashboard from '../components/CourseCreatorDashboard.vue';
import ModeratorDashboard from '../components/ModeratorDashboard.vue';
import { useRouter } from 'vue-router';

const user = ref({});
const errorMessage = ref('');

const router = useRouter();

const fetchUser = async () => {
    try {
        const response = await apiClient.get('/user');
        user.value = response.data;
        console.log('Fetched user data:', user.value); // Add this line
    } catch (error) {
        console.error('Failed to fetch user data:', error);
        errorMessage.value = 'Failed to fetch user data.';
        router.push('/login');
    }
};

const handleLogout = async () => {
    try {
        const response = await apiClient.post('/logout');
        console.log('Logout response:', response.data);
        localStorage.removeItem('token');
        router.push('/login');
    } catch (error) {
        console.error('Failed to logout:', error);
        errorMessage.value = error.response?.data?.message || 'Failed to logout.';
    }
};

onMounted(fetchUser);
</script>
