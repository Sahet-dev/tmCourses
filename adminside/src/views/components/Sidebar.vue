<template>
    <aside class="w-64 bg-white shadow-md">
        <div class="p-4">
            <h2 class="text-xl font-semibold">Dashboard</h2>
            <ul class="mt-6">
                <li><router-link to="/dashboard" class="block px-4 py-2 hover:bg-gray-200">Home</router-link></li>
                <li v-if="isAdmin || isModerator">
                    <router-link to="/courses" class="block px-4 py-2 hover:bg-gray-200">Courses</router-link>
                </li>
                <li v-if="isAdmin">
                    <router-link to="/users" class="block px-4 py-2 hover:bg-gray-200">Users</router-link>
                </li>
                <li v-if="isCourseCreator">
                    <router-link to="/my-courses" class="block px-4 py-2 hover:bg-gray-200">My Courses</router-link>
                </li>
                <li>
                    <button @click="logout" class="block px-4 py-2 w-full text-left hover:bg-gray-200">Logout</button>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script>
import apiClient from "../../api/axios.js";

export default {
    data() {
        return {
            user: {}
        };
    },
    computed: {
        isAdmin() {
            return this.user.role === 'admin';
        },
        isModerator() {
            return this.user.role === 'moderator';
        },
        isCourseCreator() {
            return this.user.role === 'teacher';
        }
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
    mounted() {
        this.fetchUser();
    }
};
</script>
