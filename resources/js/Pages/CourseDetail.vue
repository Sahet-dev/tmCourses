<template>
    <div>
        <Navbar />
        <div class="container mx-auto p-4 overflow-y-auto">
            <h1 class="text-2xl font-bold mb-6">Course Catalog</h1>
                <img :src="course.thumbnail" alt="course.title" class="w-full h-48 object-cover rounded mb-4" />
                <h2 class="text-xl font-semibold mb-2">{{ course.title }}</h2>
                <p class="text-gray-700 mb-2">{{ course.description }}</p>
                <p class="text-lg font-bold mb-2">${{ course.price }}</p>
        </div>
    </div>

</template>

<script>
import Navbar from "@/Pages/Navbar.vue";

export default {
    components: {Navbar},
    props: {
        course: Object,
    },
};
</script>
