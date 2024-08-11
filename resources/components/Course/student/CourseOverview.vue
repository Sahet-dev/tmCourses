<template>
    <div class="p-8 bg-gray-100 min-h-screen">
        <!-- Course Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h1 class="text-3xl font-semibold text-gray-800 mb-2">Course Title</h1>
            <p class="text-gray-600 mb-4">This is a brief description of the course. It provides an overview of what the course will cover, key learning objectives, and any prerequisites.</p>
            <div class="flex items-center space-x-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 shadow">
                    Enroll Now
                </button>
                <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 shadow">
                    Learn More
                </button>
            </div>
        </div>

        <!-- Lessons List -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Course Lessons</h2>
            <ul class="space-y-4">
                <li v-for="lesson in lessons" :key="lesson.id" class="p-4 bg-gray-50 rounded-md shadow">
                    <h3 class="text-xl font-medium text-gray-800">{{ lesson.title }}</h3>
                    <p class="text-gray-600">{{ lesson.description }}</p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "CourseOverview",
    data() {
        return {
            lessons: [
                { id: 1, title: "Introduction", description: "An introduction to the course and its goals." },
                { id: 2, title: "Lesson 1", description: "Overview of the first major topic." },
                { id: 3, title: "Lesson 2", description: "Detailed exploration of the second major topic." },
                // Add more lessons as needed
            ],
        };
    },
};
</script>

<style scoped>
/* Add any scoped styles if needed */
</style>
