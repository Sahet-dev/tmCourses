<template>
    <div>


        <DashboardHeader @logout="handleLogout" />

        <div class="flex">
            <main class="flex-1">


                <AdminDashboard v-if="user.role === 'admin'" />
                <TeacherDashboard v-if="user.role === 'teacher'" />
                <ModeratorDashboard v-if="user.role === 'moderator'" />
                <div class="text-red-500" v-if="errorMessage">{{ errorMessage }}</div>


            </main>

        </div>
        <Footer />
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import apiClient from '../api/axios';
import DashboardHeader from "../components/DashboardHeader.vue";
import AdminSidebar from "../components/Course/admin/AdminSidebarList.vue";
import AdminDashboard from '../components/Course/admin/AdminDashboard.vue';
import ModeratorDashboard from '../components/Course/moderator/ModeratorDashboard.vue';
import { useRouter } from 'vue-router';
import TeacherDashboard from "../components/Course/teacher/TeacherDashboard.vue";
import Footer from "./components/Footer.vue";

const user = ref({});
const errorMessage = ref('');

const router = useRouter();

const fetchUser = async () => {
    try {
        const response = await apiClient.get('/user');
        user.value = response.data;
        console.log('Fetched user data:', user.value);
    } catch (error) {
        if (error.response?.status === 401) {
            // User is unauthorized, redirect to login page
            router.push('/login');
        } else {
            console.error('Failed to fetch user data:', error);
            errorMessage.value = 'Failed to fetch user data.';
        }
    }
};

const handleLogout = async () => {
    try {
        const response = await apiClient.post('/logout');
        console.log('Logout response:', response.data);
        localStorage.removeItem('token'); // Clear token from localStorage
        router.push('/login'); // Redirect to login page
    } catch (error) {
        console.error('Failed to logout:', error);
        errorMessage.value = error.response?.data?.message || 'Failed to logout.';
    }
};

onMounted(fetchUser);
</script>
