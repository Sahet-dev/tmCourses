import { createRouter, createWebHistory } from 'vue-router';
import CourseCatalog from "@/Pages/CourseCatalog.vue";
import CourseDetail from "@/Pages/CourseDetail.vue";
import NotificationsPage from "@/Pages/NotificationsPage.vue";
import Activity from "@/Pages/Activity.vue";
import Account from '@/Pages/Account.vue';
import Bookmarks from '@/Pages/Bookmarks.vue';
import Completed from '@/Pages/Completed.vue';
import NotFound from "@/Pages/NotFound.vue";
import Login from "@/Pages/Auth/Login.vue";

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

    {
        path: '/',
        name: 'Activity',
        component: Activity,
    },
    {
        path: '/account',
        name: 'Account',
        component: Account,
    },
    {
        path: '/bookmarks',
        name: 'Bookmarks',
        component: Bookmarks,
    },
    {
        path: '/completed',
        name: 'Completed',
        component: Completed,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: NotFound,
    },
    {
        path: '/:pathMatch(.*)*', // Vue Router catch-all syntax
        name: 'NotFound',
        component: NotFound,
    },
    {
        path: '/login',
        name: 'login',  // This name should match what you use in router.push({ name: 'login' })
        component: Login,
    },

];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
