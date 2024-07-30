<template>
    <div>
        <Navbar />
        <div class="flex bg-gray-100 p-4 shadow">
            <!-- Sidebar (Hidden on mobile devices) -->
            <Sidebar
                v-show="!isMobile"
                :lessons="course.lessons"
                :selectedLesson="selectedLesson"
                @update:selectedLesson="setSelectedLesson"
                :totalLessons="totalLessons"
                :formattedTotalDuration="formattedTotalDuration"
                :completionPercentage="completionPercentage"
                class="flex-shrink-0"
            />

            <!-- Content Area -->
            <div :class="{'w-full': isMobile, 'w-3/4': !isMobile}" class="p-4 bg-white ml-2">
                <h1 class="text-2xl font-bold mb-6">{{ course.title }}</h1>
                <img :src="course.thumbnail" alt="course.title" class="w-full h-48 object-cover rounded mb-4" />
                <p class="text-gray-700 mb-2">{{ course.description }}</p>
                <p class="text-lg font-bold mb-2">${{ course.price }}</p>

                <!-- Lesson Details -->
                <div v-if="selectedLesson" class="bg-white rounded shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-2">{{ selectedLesson.title }}</h2>
                    <video :src="selectedLesson.video_url" controls class="w-full h-48 object-cover rounded mb-4 aspect-ratio-16/9"></video>
                    <div v-html="selectedLesson.markdown_text"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Sidebar from '@/Pages/Sidebar.vue';
import Navbar from "@/Pages/Navbar.vue";

export default {
    components: {
        Navbar,
        Sidebar,
    },
    props: {
        course: Object,
    },
    data() {
        return {
            selectedLesson: this.course.lessons[0] || null,
            isMobile: window.innerWidth < 768,
        };
    },
    computed: {
        totalLessons() {
            return this.course.lessons.length;
        },
        totalDuration() {
            return this.course.lessons.reduce((total, lesson) => {
                if (!lesson.duration) return total;
                const [hours, minutes, seconds] = lesson.duration.split(':').map(Number);
                return total + (hours * 3600) + (minutes * 60) + seconds;
            }, 0);
        },
        formattedTotalDuration() {
            const hours = Math.floor(this.totalDuration / 3600);
            const minutes = Math.floor((this.totalDuration % 3600) / 60);
            const seconds = this.totalDuration % 60;
            return `${hours}:${minutes}:${seconds}`;
        },
        completionPercentage() {
            const completedLessons = this.course.lessons.filter(lesson => lesson.completed).length;
            return Math.round((completedLessons / this.totalLessons) * 100);
        },
    },
    methods: {
        setSelectedLesson(lesson) {
            this.selectedLesson = lesson;
        },
        handleResize() {
            this.isMobile = window.innerWidth < 768;
        },
    },
    mounted() {
        window.addEventListener('resize', this.handleResize);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.handleResize);
    },
};
</script>
