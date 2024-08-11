<template>
    <div class="max-w-4xl mx-auto py-12 px-6 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ course.title }} (Limited Access)</h1>
        <p class="text-lg text-gray-600 mb-8">{{ course.description }}</p>

        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Available Lessons:</h2>
        <ul class="space-y-3">
            <li v-for="lesson in limitedLessons" :key="lesson.id" class="bg-gray-100 p-4 rounded-lg shadow-sm">
                <span class="text-xl text-gray-700">{{ lesson.title }}</span>
            </li>
        </ul>

        <p class="text-center text-lg text-gray-700 mt-8">
            To access all lessons, please
            <router-link to="/login" class="text-blue-600 hover:underline">log in</router-link>
            or
            <router-link to="/register" class="text-blue-600 hover:underline">register</router-link>.
        </p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            course: {
                title: 'Course Title',
                description: 'Course Description',
            },
            limitedLessons: [
                { id: 1, title: 'Lesson 1' },
                { id: 2, title: 'Lesson 2' },
            ],
        };
    },
    mounted() {
        // Fetch the course and limited lessons details from the API
        const courseId = this.$route.params.id;
        // Use axios or fetch to retrieve limited course data
        // axios.get(`/api/courses/${courseId}/limited`).then(response => {
        //   this.course = response.data.course;
        //   this.limitedLessons = response.data.lessons;
        // });
    },
};
</script>

<style scoped>
/* You can add custom styles here if needed */
</style>
