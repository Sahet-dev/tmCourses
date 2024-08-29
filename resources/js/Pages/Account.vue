<template>
    <div class="max-w-2xl mx-auto p-4 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-bold mb-4">Account Details</h1>
        <div v-if="loading" >
            <Loader />
        </div>
        <div v-else>
            <div class="mb-4">
                <h2 class="text-lg font-semibold">User Information</h2>
                <p><strong>Name:</strong> {{ user.name }}</p>
                <p><strong>Email:</strong> {{ user.email }}</p>
                <p><strong>Joined:</strong> {{ user.created_at }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold">Subscription Information</h2>
                <p><strong>Plan:</strong> {{ accountDetails.plan }}</p>
                <p><strong>Expires At:</strong> {{ accountDetails.expires_at }}</p>
                <p><strong>Last Payment:</strong> {{ accountDetails.last_payment }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import apiClient from "@/axios.js";
import Loader from "@/Pages/components/Loader.vue"; // Adjust the path as needed

const user = ref({});
const accountDetails = ref({});
const loading = ref(true);

const fetchData = async () => {
    try {
        const response = await apiClient.get('/account');
        user.value = response.data.user;
        accountDetails.value = response.data.accountDetails;
    } catch (error) {
        console.error('Error fetching account data:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchData();
});
</script>

<style scoped>
/* Add any custom styles you want for the Account page */
</style>
