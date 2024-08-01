import { createRouter, createWebHistory } from 'vue-router';
import Courses from "../views/Courses.vue";
import Dashboard from "../views/Dashboard.vue";
import HelloWorld from "../components/HelloWorld.vue";
import Login from "../components/Login.vue";

const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
    },
    {
        path: '/courses',
        name: 'courses',
        component: Courses,
    }, {
        path: '/helloworld',
        name: 'helloworld',
        component: HelloWorld,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const token = localStorage.getItem('token');
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!token) {
            next('/login');
        } else {
            try {
                await apiClient.get('/user'); // Verify token
                next();
            } catch (error) {
                localStorage.removeItem('token');
                next('/login');
            }
        }
    } else {
        next();
    }
});

export default router;
