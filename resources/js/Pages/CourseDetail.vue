<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">{{ course.title }}</h1>
        <img :src="course.thumbnail" alt="course.title" class="w-full h-48 object-cover rounded mb-4" />
        <p class="text-gray-700 mb-2">{{ course.description }}</p>
        <p class="text-lg font-bold mb-2">${{ course.price }}</p>
        <div v-for="lesson in course.lessons" :key="lesson.id" class="bg-white rounded shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-2">{{ lesson.title }}</h2>
            <video :src="lesson.video_url" controls class="w-full h-48 object-cover rounded mb-4"></video>
            <div v-html="lesson.markdown_text"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        course: Object,
    },
};
</script>
