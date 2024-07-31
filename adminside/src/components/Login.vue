<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 bg-white rounded shadow-md">
            <h2 class="text-2xl font-bold mb-6">Admin Login</h2>
            <form @submit.prevent="login">
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" v-model="email" class="w-full px-3 py-2 border rounded" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Password</label>
                    <input type="password" v-model="password" class="w-full px-3 py-2 border rounded" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">
                        <input type="checkbox" v-model="remember" /> Remember me
                    </label>
                </div>
                <div class="text-red-500 mb-4" v-if="errorMessage">{{ errorMessage }}</div>
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
import apiClient from '../api/axios';
import { useRouter } from 'vue-router';

export default {
    data() {
        return {
            email: '',
            password: '',
            remember: false,
            errorMessage: ''
        };
    },
    setup() {
        const router = useRouter();
        return { router };
    },
    methods: {
        async login() {
            try {
                const response = await apiClient.post('login', {
                    email: this.email,
                    password: this.password,
                    remember: this.remember
                });
                console.log(response.data);
                // Handle successful login
                localStorage.setItem('token', response.data.token);
                this.router.push('/dashboard'); // Redirect to the dashboard or desired route
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'An error occurred';
            }
        }
    }
};
</script>

<style scoped>
h2 {
    color: #333;
}
</style>
