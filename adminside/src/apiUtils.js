// import apiClient from "./api/axios.js"; // Adjust path if needed
// import { useRouter } from 'vue-router';
//
//
// const router = useRouter();
//
// export const fetchUser = async (user, errorMessage) => {
//     try {
//         const response = await apiClient.get('/user');
//         user.value = response.data;
//         console.log('Fetched user data:', user.value);
//     } catch (error) {
//         if (error.response?.status === 401) {
//             // User is unauthorized, redirect to login page
//             router.push('/login');
//         } else {
//             console.error('Failed to fetch user data:', error);
//             errorMessage.value = 'Failed to fetch user data.';
//         }
//     }
// };
