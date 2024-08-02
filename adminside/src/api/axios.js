// api/axios.js
import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json',
    },
});



apiClient.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    console.log('Sending token:', token); // Log token to ensure it's being sent
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});


export default apiClient;
