<script setup>
defineProps(
    {
        selected: Boolean,
        text: String
    }
)
</script>

<template>
    <button
        :class="['px-3 py-2.5 outline-none hidden md:block  ml-2 font-bold',
                 selected
                 ? ' text-sky-800 border-b-2 border-sky-700'
                 : 'text-amber-600 hover:text-amber-700',]">
        {{ text }}
    </button>
</template>

<style scoped>
.orange {
    font-weight: bold;
    color: #e49e58;
}
.selected-tab {
    color: #5daeec;
    text-decoration: none; /* Remove text underline */
    border-bottom: 2px solid #5daeec; /* Add border to the bottom */
    padding-bottom: 2px;
}
</style>
