import { createRouter, createWebHistory } from 'vue-router';
import CourseDetail from "@/Pages/CourseDetail.vue";
import NotificationsPage from "@/Pages/NotificationsPage.vue";


const routes = [
    {
        path: '/notifications',
        name: 'notifications',
        component: () => import('@/Pages/NotificationsPage.vue'),
    },

    {
        path: '/courses/:id',
        name: 'courseDetail',
        component: CourseDetail,
        props: true,
    },
    {
        path: '/notifications',
        component: NotificationsPage,
        props: true,

    },




];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
