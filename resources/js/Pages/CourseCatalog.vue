<template>
    <div>
        <Navbar />
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-6">Course Catalog</h1>
            <div v-for="course in courses" :key="course.id" class="bg-white rounded shadow p-6 mb-6">
                <img :src="course.thumbnail" alt="course.title" class="w-full h-48 object-cover rounded mb-4" />
                <h2 class="text-xl font-semibold mb-2">{{ course.title }}</h2>
                <p class="text-gray-700 mb-2">{{ course.description }}</p>
                <p class="text-lg font-bold mb-2">${{ course.price }}</p>
                <a :href="route('courseDetail', course.id)" class="text-blue-500 hover:underline" @click="navigate(course.detail_url)">View Course</a>
                <p>{{ $route.name }}</p> <!-- Debugging output -->
            </div>
        </div>
    </div>

</template>

<script>
import Navbar from "@/Pages/Navbar.vue";

export default {
    components: {Navbar},
    props: {
        courses: Array,
    },
};
</script>
