<template>
    <DashboardHeader />
    <div v-if="course" class="mx-auto p-6 bg-white rounded-md shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Update Course and Lessons</h2>
<!--        <img :src="course.thumbnailUrl" alt="Course Thumbnail">-->

        <form @submit.prevent="updateCourseAndLessons" enctype="multipart/form-data">
            <!-- Course Form -->
            <div class="mb-4">
                <label for="title" class="block text-lg font-medium text-gray-700">Course Title</label>
                <input v-model="course.title" id="title" type="text" class="w-full px-3 py-2 border rounded-md" required />
            </div>
            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-gray-700">Course Description</label>
                <textarea v-model="course.description" id="description" class="w-full px-3 py-2 border rounded-md" required></textarea>
            </div>
            <div class="mb-4">
                <label for="thumbnail" class="block text-lg font-medium text-gray-700">Course Thumbnail</label>
                <input @change="handleFileUpload" id="thumbnail" type="file" class="w-full px-3 py-2 border rounded-md" />
                <img v-if="thumbnailPreview || course.thumbnailUrl" :src="thumbnailPreview || course.thumbnailUrl" alt="Thumbnail Preview" class="mt-2 w-32 h-32 object-cover" />
            </div>
            <div class="mb-4">
                <label for="price" class="block text-lg font-medium text-gray-700">Price</label>
                <input v-model="course.price" id="price" type="number" step="0.01" class="w-full px-3 py-2 border rounded-md" required />
            </div>

            <!-- Lesson Form -->
            <div v-for="(lesson, index) in lessons" :key="index" class="mb-4 border-b border-gray-300 pb-4">
                <h3 class="text-lg font-medium text-gray-700 mb-2">Lesson {{ index + 1 }}</h3>
                <input v-if="lesson.id" type="hidden" v-model="lesson.id" />
                <div class="mb-4">
                    <label :for="'lessonTitle' + index" class="block text-lg font-medium text-gray-700">Lesson Title</label>
                    <input v-model="lesson.title" :id="'lessonTitle' + index" type="text" class="w-full px-3 py-2 border rounded-md" required />
                </div>
                <div class="mb-4">
                    <label :for="'video_url' + index" class="block text-lg font-medium text-gray-700">Video file</label>
                    <input @change="handleVideoUpload($event, index)" :id="'video_url' + index" type="file" class="w-full px-3 py-2 border rounded-md" />
                    <p v-if="lesson.video_url" class="mt-2">{{ lesson.video_url }}</p>
                </div>
                <div class="mb-4">
                    <label :for="'markdown_text' + index" class="mt-6 block text-lg font-medium text-gray-700">Markdown Text</label>
                    <ckeditor
                        v-model="lesson.markdown_text"
                        :editor="editor"
                        :config="editorConfig"
                    />
                </div>
            </div>
            <button type="button" @click="addLesson" class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded-md shadow-sm hover:bg-gray-300 mb-4">+ Add Another Lesson</button>

            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600">Update Course and Lessons</button>
            <div v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</div>
        </form>

    </div>
    <div v-else class="text-gray-500">Loading course data...
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import apiClient from "../../api/axios.js";
import { ClassicEditor, Bold, Essentials, Italic, Mention, Paragraph,
    Undo, Link, Code,  Strikethrough, Subscript, Superscript,
    Underline, Font,CodeBlock, Indent, IndentBlock   } from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';
import DashboardHeader from "../DashboardHeader.vue";

const editor = ClassicEditor;
const editorConfig = {
    plugins: [
        Bold, Essentials, Italic, Mention, Paragraph,
        Undo, Link, Code, Strikethrough, Subscript,
        Superscript, Underline, Font, CodeBlock,
        Indent, IndentBlock
    ],
    toolbar: {
        items: [
            'undo', 'redo', '|', 'bold', 'italic', 'underline',
            'strikethrough', 'subscript', 'superscript',
            'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor',
            'link', 'code', 'codeBlock'
        ]
    }
};

const route = useRoute();
const router = useRouter();

const course = ref(null);
const lessons = ref([]);
const errorMessage = ref('');
const thumbnailPreview = ref(null);

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    thumbnailPreview.value = URL.createObjectURL(file);
    course.value.thumbnail = file;
};

const handleVideoUpload = (event, index) => {
    const file = event.target.files[0];
    lessons.value[index].video_url = file;
};

const addLesson = () => {
    lessons.value.push({
        title: '',
        video_url: null,
        markdown_text: '',
    });
};

const fetchCourse = async (id) => {
    try {
        const response = await apiClient.get(`/courses/${id}`);

        // Use response.data directly as it contains the course data
        const courseData = response.data.course;
        course.value = {
            id: courseData.id || null,
            title: courseData.title || '',
            description: courseData.description || '',
            thumbnail: courseData.thumbnail || '', // Handle missing thumbnail
            price: courseData.price || null,
            thumbnailUrl: courseData.thumbnail || '' // Fallback value for preview
        };

        // Handle lessons data if available
        if (Array.isArray(courseData.lessons)) {
            lessons.value = courseData.lessons.map((lesson) => ({
                id: lesson.id || null,
                title: lesson.title || '',
                video_url: lesson.video_url || '',
                markdown_text: lesson.markdown_text || '',
            }));
        } else {
            console.error('Lessons data is missing or not an array:', courseData.lessons);
            console.error('lessons.value:', lessons.value);
            lessons.value = [];
            errorMessage.value = 'Lessons data is missing or invalid.';
        }

    } catch (error) {
        console.error('Failed to fetch course data:', error);
        errorMessage.value = 'Failed to load course data.';
    }
};


const updateCourseAndLessons = async () => {
    try {
        const formData = new FormData();

        // Append only non-empty fields
        if (course.value.title) {
            formData.append('title', course.value.title);
        }

        if (course.value.description) {
            formData.append('description', course.value.description);
        }

        if (course.value.price) {
            formData.append('price', course.value.price);
        }

        // Only append the thumbnail if it's a new file
        if (course.value.thumbnail instanceof File) {
            formData.append('thumbnail', course.value.thumbnail);
        }

        // Only append lessons if they exist
        if (lessons.value.length > 0) {
            lessons.value.forEach((lesson, index) => {
                if (lesson.id) {
                    formData.append(`lessons[${index}][id]`, lesson.id);
                }
                if (lesson.title) {
                    formData.append(`lessons[${index}][title]`, lesson.title);
                }
                if (lesson.video_url instanceof File) {
                    formData.append(`lessons[${index}][video_url]`, lesson.video_url);
                }
                if (lesson.markdown_text) {
                    formData.append(`lessons[${index}][markdown_text]`, lesson.markdown_text);
                }
            });
        }

        const response = await apiClient.put(`/courses/${course.value.id}`, formData);

        // Display a success message if the update was successful
        if (response.data.message) {
            successMessage.value = response.data.message;
        }
    } catch (error) {
        console.error(error);
        errorMessage.value = 'An error occurred while updating the course and lessons.';
    }
};




onMounted(() => {
    const courseId = route.params.id;
    if (courseId) {
        fetchCourse(courseId);
    }
});
</script>
