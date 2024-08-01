<template>
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-lg font-semibold">Dashboard</h1>
            <button @click="$emit('logout')" class="bg-red-500 px-4 py-2 rounded">
                Logout
            </button>
        </div>
    </header>
</template>

<script>
export default {
    name: 'DashboardHeader',
};
</script>

<style scoped>
/* Header styles */
</style>
