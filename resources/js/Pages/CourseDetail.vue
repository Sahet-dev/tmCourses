<template>
    <div>
        <Navbar />
        <div class="container mx-auto overflow-y-auto">
            <h1 class="text-2xl font-bold mb-6">{{ course.title }}</h1>
            <img :src="thumbnailUrl" :alt="course.title" class="w-full h-48 object-cover rounded mb-4" />
            <p class="text-gray-700 mb-2">{{ course.description }}</p>
            <p class="text-lg font-bold mb-2">${{ course.price }}</p>

            <!-- Sidebar and Content Area -->
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
                <div :class="{'w-full': isMobile, 'w-3/4': !isMobile}" class="bg-white m-2">
                    <div v-if="selectedLesson" class="rounded shadow p-2 mb-6">
                        <h4 class="text-lg font-semibold mb-2">{{ selectedLesson.title }}</h4>
                        <video v-if="selectedLesson.video_url" :src="lessonVideoUrl(selectedLesson.video_url)" controls class="w-full h-80 object-cover rounded mb-4 aspect-ratio-16"></video>
                        <div v-html="selectedLesson.markdown_text"></div>
                    </div>
                    <!-- Show only titles for remaining lessons -->
                    <div v-else>
                        <h4 v-for="lesson in titleOnlyLessons" :key="lesson.id" class="text-lg font-semibold mb-2">{{ lesson.title }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, computed, onMounted, onBeforeUnmount} from 'vue';
import Sidebar from '@/Pages/Sidebar.vue';
import Navbar from '@/Pages/Navbar.vue';

const props = defineProps({
    course: Object,
    detailedLessons: Array,
    titleOnlyLessons: Array,
});

const course = ref(props.course);
const detailedLessons = ref(props.detailedLessons);
const titleOnlyLessons = ref(props.titleOnlyLessons);
const selectedLesson = ref(detailedLessons.value[0] || null);

// Reactive state
const isMobile = ref(window.innerWidth < 768);

// Computed properties
const totalLessons = computed(() => course.value.lessons?.length || 0);
const totalDuration = computed(() => {
    return course.value.lessons?.reduce((total, lesson) => {
        if (!lesson.duration) return total;
        const [hours, minutes, seconds] = lesson.duration.split(':').map(Number);
        return total + (hours * 3600) + (minutes * 60) + seconds;
    }, 0) || 0;
});
const formattedTotalDuration = computed(() => {
    const hours = Math.floor(totalDuration.value / 3600);
    const minutes = Math.floor((totalDuration.value % 3600) / 60);
    const seconds = totalDuration.value % 60;
    return `${hours}:${minutes}:${seconds}`;
});
const completionPercentage = computed(() => {
    const completedLessons = course.value.lessons?.filter(lesson => lesson.completed).length || 0;
    return Math.round((completedLessons / totalLessons.value) * 100);
});

// Methods
function setSelectedLesson(lesson) {
    selectedLesson.value = lesson;
}

const lessonVideoUrl = (videoUrl) => {
    return `/storage/${videoUrl}`;
};

const thumbnailUrl = computed(() => `/storage/${course.value.thumbnail}`);

// Resize handling
const handleResize = () => {
    isMobile.value = window.innerWidth < 768;
};

onMounted(() => {
    window.addEventListener('resize', handleResize);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', handleResize);
});
</script>
