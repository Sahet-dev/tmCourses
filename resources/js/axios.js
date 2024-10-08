import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    }
});

export const setupCsrf = async () => {
    await apiClient.get('/sanctum/csrf-cookie'); // This will set the `XSRF-TOKEN` cookie
};

// Interceptor to add token to headers
apiClient.interceptors.request.use(config => {
    const token = localStorage.getItem('token'); // Adjust as needed for how you store tokens
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

export default apiClient;
