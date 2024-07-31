<template>
    <div class="flex h-screen bg-gray-100">
        <Sidebar />
        <main class="flex-1 p-6">
            <component :is="currentDashboard" :user="user" />
        </main>
    </div>
</template>

<script>
import Sidebar from './components/Sidebar.vue';
import AdminDashboard from "../components/AdminDashboard.vue";
import ModeratorDashboard from '../components/ModeratorDashboard.vue';
import CourseCreatorDashboard from '../components/CourseCreatorDashboard.vue';

export default {
    components: {
        Sidebar,
        AdminDashboard,
        ModeratorDashboard,
        CourseCreatorDashboard
    },
    data() {
        return {
            user: {},
            currentDashboard: AdminDashboard // Default dashboard
        };
    },
    async created() {
        try {
            const response = await apiClient.get('/user');
            this.user = response.data;

            if (this.user.role === 'admin') {
                this.currentDashboard = AdminDashboard;
            } else if (this.user.role === 'moderator') {
                this.currentDashboard = ModeratorDashboard;
            } else if (this.user.role === 'teacher') {
                this.currentDashboard = CourseCreatorDashboard;
            }
        } catch (error) {
            console.error('Failed to fetch user data:', error);
            this.$router.push('/login');
        }
    }
};
</script>
