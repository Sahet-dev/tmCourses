<template>
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto flex flex-col items-center md:flex-row md:justify-between">
            <!-- Footer Links -->
            <div class="mb-4 md:mb-0">
                <h4 class="text-lg font-semibold mb-2">Quick Links</h4>
                <ul class="space-y-1">
                    <li><router-link to="/" class="hover:text-gray-400">Home</router-link></li>
                    <li><router-link to="/about" class="hover:text-gray-400">About Us</router-link></li>
                    <li><router-link to="/services" class="hover:text-gray-400">Services</router-link></li>
                    <li><router-link to="/contact" class="hover:text-gray-400">Contact</router-link></li>
                </ul>
            </div>

            <!-- Social Media Links -->
            <div class="mb-4 md:mb-0">
                <h4 class="text-lg font-semibold mb-2">Follow Us</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.04c-5.49 0-9.95 4.46-9.95 9.95 0 4.45 2.92 8.21 6.85 9.5v-6.73h-2.06v-2.66h2.06v-2.02c0-2.04 1.23-3.14 3.05-3.14.86 0 1.78.15 1.78.15v1.96h-.99c-.98 0-1.29.61-1.29 1.24v1.49h2.2l-.35 2.66h-1.85v6.73c3.93-1.29 6.85-5.05 6.85-9.5 0-5.49-4.46-9.95-9.95-9.95z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23 3.6c-.9.4-1.86.66-2.88.78 1.04-.62 1.84-1.6 2.22-2.77-.97.57-2.05.98-3.18 1.2-.91-.97-2.21-1.58-3.64-1.58-2.77 0-5.02 2.25-5.02 5.02 0 .39.04.77.12 1.13-4.17-.21-7.87-2.21-10.35-5.27-.43.74-.68 1.6-.68 2.52 0 1.74.89 3.27 2.24 4.17-.83-.03-1.61-.26-2.29-.64v.06c0 2.42 1.73 4.44 4.02 4.91-.42.12-.86.18-1.32.18-.32 0-.64-.03-.95-.09.64 2 2.5 3.46 4.68 3.5-1.73 1.36-3.92 2.17-6.3 2.17-.41 0-.82-.02-1.22-.07 2.27 1.46 4.96 2.31 7.88 2.31 9.48 0 14.65-7.86 14.65-14.65 0-.22-.01-.43-.02-.65.99-.72 1.84-1.62 2.51-2.66z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21.5 3h-19c-1.38 0-2.5 1.12-2.5 2.5v13c0 1.38 1.12 2.5 2.5 2.5h19c1.38 0 2.5-1.12 2.5-2.5v-13c0-1.38-1.12-2.5-2.5-2.5zm-9.5 14h-2v-6h2v6zm-1-7.5c-.69 0-1.25-.56-1.25-1.25s.56-1.25 1.25-1.25 1.25.56 1.25 1.25-.56 1.25-1.25 1.25zm7.5 7h-2v-3.5c0-1.68-1.42-3-3-3s-3 1.32-3 3v3.5h-2v-6h2v.84c1.34-1.84 3.54-3.09 6-3.09 4.42 0 8 3.58 8 8v3.09z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Copyright Information -->
            <div class="text-center md:text-right">
                <p class="text-sm">&copy; 2024 Lone Wolf. All rights reserved.</p>
            </div>
        </div>
    </footer>
</template>

<style scoped>
/* Scoped styles if needed */
</style>
