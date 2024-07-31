<template>
    <div>
        <DashboardHeader :user="user" />
        <div>
            <h2 class="text-xl font-semibold">Admin Dashboard</h2>
            <!-- Admin-specific content -->
            <p>Admin content goes here.</p>
        </div>
    </div>
</template>

<script>
import DashboardHeader from './DashboardHeader.vue';

export default {
    components: {
        DashboardHeader
    },
    data() {
        return {
            user: {}
        };
    },
    async created() {
        // Fetch user data or any required data
    }
};
</script>
