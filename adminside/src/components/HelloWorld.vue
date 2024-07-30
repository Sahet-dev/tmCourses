<script setup>
import { ref } from 'vue'

defineProps({
  msg: String,
})

const count = ref(0)
</script>

<template>
    <div class="p-4 bg-blue-500 text-white">
        Hello, Tailwind CSS with Vite!
    </div>
</template>

<style scoped>

</style>
