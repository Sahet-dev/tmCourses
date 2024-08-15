<template>
    <div class="w-64 bg-gray-200 p-4">

            <button @click="editCourse(courseId)"
                    class=" w-full text-left px-2 py-1 rounded hover:bg-gray-300 mb-4 hover:text-blue-500">
                Edit Course Data
            </button>
        <h3 class="text-xl font-bold mb-4">Lessons</h3>
        <ul>
            <li v-for="(lesson, index) in lessons" :key="index" class="mb-2">
                <button
                    @click="$emit('update:selectedLesson', index)"
                    class="w-full text-left px-2 py-1 rounded hover:bg-gray-300 border border-transparent hover:border-blue-700"
                    :class="{'bg-gray-300': selectedLesson === index}"
                >
                    {{ lesson.title || `Lesson ${index + 1}` }}
                </button>
            </li>
        </ul>
    </div>
</template>

<script setup>
import {defineProps, defineEmits, ref} from 'vue';
import {useRouter} from "vue-router";
import apiClient from "../../api/axios.js";

const props = defineProps({
    courseId: {
        type: [String, Number],
        default: null, // or false if it's optional
    },
    lessons: {
        type: Array,
        required: true
    },
    selectedLesson: {
        type: Number,
        required: true
    }
});
const editCourse = (courseId) => {
    if (courseId) {
        router.push({ name: 'CourseData', params: { id: courseId } });
    } else {
        console.warn('Course ID is missing. Cannot edit course data.');
    }
};;
const emit = defineEmits(['update:selectedLesson']);

const course = ref(null);
const router = useRouter();
const fetchCourses = async () => {
    try {
        const response = await apiClient.get('/teacher/courses');
        courses.value = response.data.data;
    } catch (error) {
        console.error('Failed to fetch courses:', error);
    }
};



fetchCourses();
</script>
