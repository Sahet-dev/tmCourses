<template>
    <div>
        <Navbar />
        {{ course }}
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
                    <video :src="selectedLesson.video_url" controls class="w-full h-48 object-cover rounded mb-4 aspect-ratio-16"></video>
                    <div v-html="selectedLesson.markdown_text"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, computed, onMounted, onBeforeUnmount} from 'vue';
import {usePage} from '@inertiajs/inertia-vue3';
import Sidebar from '@/Pages/Sidebar.vue';
import Navbar from '@/Pages/Navbar.vue';
import axios from 'axios';


// Get course data from Inertia props
const {props} = usePage();
console.log(props); // Debug: Check the contents of props
const course = ref(props.course || {});
const selectedLesson = ref(course.value.lessons?.[0] || null);
const post = ref(null);
const getPosts = () => {
    axios.get('/courses/{id}')
        .then(response => {
        post.value = response.data;
        console.log(post.value);
    })
        .catch(error=>{
            console.log(error);
        });
}
// Reactive state
const isMobile = ref(window.innerWidth < 768);

// Computed properties
const courseLessons = computed(() => course.value.lessons || []);
const totalLessons = computed(() => courseLessons.value.length);
const totalDuration = computed(() => {
    return courseLessons.value.reduce((total, lesson) => {
        if (!lesson.duration) return total;
        const [hours, minutes, seconds] = lesson.duration.split(':').map(Number);
        return total + (hours * 3600) + (minutes * 60) + seconds;
    }, 0);
});
const formattedTotalDuration = computed(() => {
    const hours = Math.floor(totalDuration.value / 3600);
    const minutes = Math.floor((totalDuration.value % 3600) / 60);
    const seconds = totalDuration.value % 60;
    return `${hours}:${minutes}:${seconds}`;
});
const completionPercentage = computed(() => {
    const completedLessons = courseLessons.value.filter(lesson => lesson.completed).length;
    return Math.round((completedLessons / totalLessons.value) * 100);
});

// Methods
function setSelectedLesson(lesson) {
    selectedLesson.value = lesson;
}

// Resize handling
const handleResize = () => {
    isMobile.value = window.innerWidth < 768;
};

onMounted(() => {
    window.addEventListener(
        // /'resize', handleResize
        ()=>getPosts()
    );

});

onBeforeUnmount(() => {
    window.removeEventListener('resize', handleResize);
});
</script>
