import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api', // Ensure this matches your Laravel backend URL
    headers: {
        'Content-Type': 'application/json',
    }
});

// Add a request interceptor
apiClient.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

export default apiClient;
