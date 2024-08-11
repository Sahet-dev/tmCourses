import { createRouter, createWebHistory } from 'vue-router';
import CourseCatalog from "@/Pages/CourseCatalog.vue";
import CourseDetail from "@/Pages/CourseDetail.vue";

const routes = [
    {
        path: '/',
        name: 'courseCatalog',
        component: CourseCatalog,
    },
    {
        path: '/courses/:id',
        name: 'courseDetail',
        component: CourseDetail,
        props: true,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
