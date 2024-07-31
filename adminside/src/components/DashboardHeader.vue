<template>
    <header class="flex justify-between items-center mb-4 p-4 bg-white shadow-md">
        <h1 class="text-2xl font-semibold">Welcome, {{ user.name }}</h1>
    </header>
</template>

<script>
export default {
    props: {
        user: Object
    }
};
</script>
