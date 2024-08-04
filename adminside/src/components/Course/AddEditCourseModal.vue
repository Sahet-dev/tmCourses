<template>
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
            <h2 class="text-xl font-semibold mb-4">{{ isEditing ? 'Edit Course' : 'Add New Course' }}</h2>
            <form @submit.prevent="save">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">Title</label>
                    <input
                        v-model="form.title"
                        type="text"
                        id="title"
                        class="w-full border border-gray-300 p-2 rounded-md"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Description</label>
                    <textarea
                        v-model="form.description"
                        id="description"
                        rows="4"
                        class="w-full border border-gray-300 p-2 rounded-md"
                        required
                    ></textarea>
                </div>
                <div class="mb-4">
                    <label for="thumbnail" class="block text-gray-700">Thumbnail URL</label>
                    <input
                        v-model="form.thumbnail"
                        type="text"
                        id="thumbnail"
                        class="w-full border border-gray-300 p-2 rounded-md"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-gray-700">Price</label>
                    <input
                        v-model="form.price"
                        type="number"
                        id="price"
                        step="0.01"
                        class="w-full border border-gray-300 p-2 rounded-md"
                        required
                    />
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" @click="close" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 transition-all duration-300">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition-all duration-300">
                        {{ isEditing ? 'Update' : 'Add' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import {defineProps, defineEmits, ref, watch} from 'vue';

const props = defineProps(['showModal', 'isEditing', 'form']);
const emit = defineEmits(['close', 'save']);

const localForm = ref({...props.form});

watch(
    () => props.form,
    (newForm) => {
        localForm.value = {...newForm};
    },
    {deep: true}
);

const close = () => {
    emit('close');
};

const save = () => {
    emit('save', localForm.value);
};
</script>

<style scoped>
/* Add your styles here */
</style>
