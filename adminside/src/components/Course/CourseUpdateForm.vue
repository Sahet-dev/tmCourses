<template>
    <DashboardHeader />
    <transition
        name="slide-fade"
        @before-enter="beforeEnter"
        @enter="enter"
        @leave="leave"
    >
        <div
            v-if="notification.visible"
            class="fixed top-4 right-4 bg-green-500 text-white p-3 rounded"
        >
            {{ notification.message }}
        </div>
    </transition>
    <div  v-bind="$attrs">

        <div v-if="lessons.length" class="flex mx-auto p-6 bg-white rounded-md shadow-md">
            <!-- Sidebar -->
            <UpdateSidebar
                :courseId="course?.id"
                :lessons="lessons"
                :selectedLesson="selectedLesson"
                @update:selectedLesson="setSelectedLesson"
                class="flex-shrink-0 mr-6"
            />

            <!-- Main Content -->
            <div class="flex-grow">
                <div v-if="selectedLesson !== null && lessons[selectedLesson]" class="mb-4">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Selected Lesson</h2>

                    <div class="mb-4 border-b border-gray-300 pb-4">
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Lesson {{ selectedLesson + 1 }}</h3>
                        <div class="mb-4">
                            <label for="lessonTitle" class="block text-lg font-medium text-gray-700">Lesson Title</label>
                            <input v-model="lessons[selectedLesson].title" id="lessonTitle" type="text" class="w-full px-3 py-2 border rounded-md" />
                        </div>
                        <div class="mb-4">
                            <label for="video_url" class="block text-lg font-medium text-gray-700">Video file</label>
                            <input type="file" @change="handleFileChange" />
                            <!-- Video Preview -->
                            <video v-if="lessons[selectedLesson].videoPreview" :src="lessons[selectedLesson].videoPreview" controls class="mt-2 w-full max-w-xs"></video>
                            <p v-if="lessons[selectedLesson].video_url && !lessons[selectedLesson].videoPreview" class="mt-2">{{ lessons[selectedLesson].video_url }}</p>
                        </div>
                        <div class="mb-4">
                            <label for="markdown_text" class="mt-6 block text-lg font-medium text-gray-700">Markdown Text</label>
                            <ckeditor
                                v-model="lessons[selectedLesson].markdown_text"
                                :editor="editor"
                                :config="editorConfig"
                                readonly
                            />
                        </div>
                    </div>
                </div>
                <button @click="updateLesson" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Save Changes</button>

                <!-- Error Message -->
                <div v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</div>
            </div>
        </div>
        <div v-else-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</div>
        <div v-else class="text-gray-500">Loading lessons...</div>
    </div>

</template>

<script setup>
import {ref, onMounted} from 'vue';
import {useRoute} from 'vue-router';
import apiClient from "../../api/axios.js";
import UpdateSidebar from "./UpdateSidebar.vue";
import DashboardHeader from "../DashboardHeader.vue";
import {
    ClassicEditor,
    Bold,
    Essentials,
    Italic,
    Mention,
    Paragraph,
    Undo,
    Link,
    Code,
    Strikethrough,
    Subscript,
    Superscript,
    Underline,
    Font,
    CodeBlock,
    Indent,
    IndentBlock
} from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';

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

const course = ref({id: null}); // Initialize with default values
const lessons = ref([]);
const selectedLesson = ref(null);
const errorMessage = ref('');
const notification = ref({
    message: '',
    visible: false
});
const fetchLessons = async (courseId) => {
    try {
        const response = await apiClient.get(`/courses/${courseId}/lessons`);
        const lessonsData = response.data.lessons;
        lessons.value = lessonsData.map((lesson) => ({
            id: lesson.id || null,
            title: lesson.title || '',
            video_url: lesson.video_url || '',
            videoPreview: lesson.video_url ? `http://127.0.0.1:8000/storage/${lesson.video_url}` : null,
            markdown_text: lesson.markdown_text || '',
        }));
        selectedLesson.value = lessonsData.length > 0 ? 0 : null;
    } catch (error) {
        console.error('Failed to fetch lessons:', error);
        errorMessage.value = 'Failed to load lessons. Please try again.';
    }
};

const setSelectedLesson = (index) => {
    selectedLesson.value = index;
};

const handleFileChange = async (event) => {
    const file = event.target.files[0];
    if (file) {
        // Handle file upload logic if needed
        console.log('Selected file:', file);
    }
};
function showNotification(message) {
    notification.value.message = message;
    notification.value.visible = true;

    setTimeout(() => {
        notification.value.visible = false;
    }, 6000); // Notification disappears after 2 seconds
}
const updateLesson = async () => {
    try {
        if (selectedLesson.value === null || lessons.value.length === 0) {
            errorMessage.value = 'No lesson selected or lessons are empty.';
            return;
        }

        const lesson = lessons.value[selectedLesson.value];

        // Check if title is present
        if (!lesson.title) {
            errorMessage.value = 'Lesson title is required.';
            return;
        }

        // Prepare data to send
        const data = {
            title: lesson.title,
        };

        // Make the PUT request
        const response = await apiClient.put(`/lessons/${lesson.id}`, data);
        showNotification('Lesson updated successfully!');
        console.log('Lesson updated successfully:', response.data);

        errorMessage.value = '';
    } catch (error) {
        console.error('Failed to update lesson:', error);
        if (error.response && error.response.data.errors) {
            errorMessage.value = Object.values(error.response.data.errors).flat().join(', ');
        } else {
            errorMessage.value = 'Failed to update lesson. Please try again.';
        }
    }
};
const fetchCourses = async () => {
    try {
        const response = await apiClient.get('/teacher/courses');
        courses.value = response.data.data; // Now courses is defined
    } catch (error) {
        console.error('Failed to fetch courses:', error);
    }
};
onMounted(() => {
    const courseId = route.params.id;
    if (courseId) {
        fetchLessons(courseId);
    }
});
fetchCourses();
</script>
<style>
/* Transition classes */
.fade-enter-active, .fade-leave-active {
    @apply transition-opacity duration-500;
}

.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    @apply opacity-0;
}
</style>
