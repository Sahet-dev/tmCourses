
<template>
    <div class="loader-wrapper">
        <div class="loader"></div>
    </div>
</template>

<style scoped>
.loader-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.12); /* Optional: Add a semi-transparent background */
    z-index: 1000;
}

.loader {
    border: 8px solid #f3f3f3; /* Light grey */
    border-top: 8px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1.5s linear infinite;
    margin: 0 auto; /* Center the loader */
    align-items: center;
    justify-content: center;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
