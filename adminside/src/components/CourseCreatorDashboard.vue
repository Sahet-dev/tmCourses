<template>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            <div class="p-4">
                <h2 class="text-xl font-semibold">Admin Dashboard</h2>
                <ul class="mt-6">
                    <li><router-link to="/dashboard" class="block px-4 py-2 hover:bg-gray-200">Home</router-link></li>
                    <li><router-link to="/courses" class="block px-4 py-2 hover:bg-gray-200">Courses</router-link></li>
                    <li><router-link to="/profile" class="block px-4 py-2 hover:bg-gray-200">Profile</router-link></li>
                    <li><button @click="logout" class="block px-4 py-2 w-full text-left hover:bg-gray-200">Logout</button></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <header class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold">Welcome, {{ user.name }}</h1>
            </header>
            <div>
                <!-- Your dashboard content goes here -->
                <p>Dashboard content...</p>
            </div>
        </main>
    </div>
</template>

<script>
import apiClient from '../api/axios';
import { ref, onMounted } from 'vue';

export default {
    data() {
        return {
            user: {
                name: ''
            }
        };
    },
    methods: {
        async fetchUser() {
            try {
                const response = await apiClient.get('/user'); // Adjust endpoint if needed
                this.user = response.data;
            } catch (error) {
                console.error('Failed to fetch user data:', error);
                this.$router.push('/login'); // Redirect to login if fetching user fails
            }
        },
        async logout() {
            try {
                await apiClient.post('/logout');
                localStorage.removeItem('token');
                this.$router.push('/login');
            } catch (error) {
                console.error('Failed to logout:', error);
            }
        }
    },
    onMounted() {
        this.fetchUser();
    }
};
</script>

<style scoped>
aside {
    min-width: 16rem;
}

header {
    border-bottom: 1px solid #e5e7eb;
}
</style>
