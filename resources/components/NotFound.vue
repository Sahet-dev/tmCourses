<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="text-center">
            <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
            <p class="text-2xl text-gray-600 mb-8">Page Not Found</p>
            <p class="text-lg text-gray-500 mb-12">The page you're looking for doesn't exist or has been moved.</p>
            <router-link
                to="/"
                class="inline-block bg-blue-600 text-white px-6 py-3 rounded-md shadow-md hover:bg-blue-700 transition duration-300"
            >
                Go Back Home
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotFound",
};
</script>

<style scoped>
/* You can add custom styles here if needed */
</style>
