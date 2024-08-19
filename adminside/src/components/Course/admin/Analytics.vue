<template>
    <div>
        <h1>Analytics Dashboard</h1>
        <p>Active Users: {{ activeUsers }}</p>
        <p>New Subscriptions: {{ newSubscriptions }}</p>
        <p>Churn Rate: {{ churnRate }}%</p>
        <p>Retention Rate: {{ retentionRate }}%</p>
        <p v-if="errorMessage">{{ errorMessage }}</p>
    </div>
</template>




<script setup>
import { ref, onMounted } from 'vue';
import apiClient from "../../../api/axios.js";

const activeUsers = ref(0);
const newSubscriptions = ref(0);
const churnRate = ref(0);
const retentionRate = ref(0);
const errorMessage = ref('');

const fetchAnalyticsData = async () => {
    const params = {
        start_date: '2024-01-01',
        end_date: '2024-08-18',
        initial_period_start: '2024-01-01',
        initial_period_end: '2024-03-01',
        retention_period_start: '2024-03-01',
        retention_period_end: '2024-08-18',
    };

    try {
        const activeUsersResponse = await apiClient.get('/analytics/active-users', { params });
        activeUsers.value = activeUsersResponse.data.active_users;
    } catch (error) {
        errorMessage.value = 'Error fetching active users.';
    }

    try {
        const newSubscriptionsResponse = await apiClient.get('/analytics/new-subscriptions', { params });
        newSubscriptions.value = newSubscriptionsResponse.data.new_subscriptions;
    } catch (error) {
        errorMessage.value = 'Error fetching new subscriptions.';
    }

    try {
        const churnRateResponse = await apiClient.get('/analytics/churn-rate', { params });
        churnRate.value = churnRateResponse.data.churn_rate;
    } catch (error) {
        errorMessage.value = 'Error fetching churn rate.';
    }

    try {
        const retentionRateResponse = await apiClient.get('/analytics/retention-rate', { params });
        retentionRate.value = retentionRateResponse.data.retention_rate;
    } catch (error) {
        errorMessage.value = 'Error fetching retention rate.';
    }
};

onMounted(() => {
    fetchAnalyticsData();
});
</script>

