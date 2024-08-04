<template>
    <div>
        <h1>Lessons for Course</h1>
        <ul>
            <li v-for="lesson in lessons" :key="lesson.id">
                <h2>{{ lesson.title }}</h2>
                <p>Video URL: <a :href="lesson.video_url" target="_blank">{{ lesson.video_url }}</a></p>
                <p>{{ lesson.markdown_text }}</p>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        courseId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            lessons: [],
            error: null,
        };
    },
    created() {
        this.fetchLessons();
    },
    methods: {
        async fetchLessons() {
            try {
                const response = await axios.get(`/api/courses/${this.courseId}/lessons`);
                this.lessons = response.data;
            } catch (error) {
                this.error = 'Failed to load lessons';
                console.error(error);
            }
        },
    },
};
</script>
