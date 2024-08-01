<template>
    <aside class="w-64 bg-gray-200 p-4">
        <ul>
            <li><router-link to="/dashboard">Home</router-link></li>
            <li v-if="role === 'admin'"><router-link to="/admin/users">Manage Users</router-link></li>
            <li v-if="role === 'admin' || role === 'teacher'"><router-link to="/courses">Courses</router-link></li>
            <li v-if="role === 'moderator'"><router-link to="/moderate">Moderate Content</router-link></li>
        </ul>
    </aside>
</template>

<script>
export default {
    name: 'Sidebar',
    props: ['role']
};
</script>

<style scoped>
/* Sidebar styles */
</style>
