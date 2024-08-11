<template>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md flex-shrink-0">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800">Student Dashboard</h2>
            </div>
            <nav class="mt-6">
                <ul>
                    <li>
                        <router-link to="/student/courses" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                            My Courses
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/student/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                            Profile
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/student/notifications" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                            Notifications
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/student/settings" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                            Settings
                        </router-link>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-grow overflow-hidden">
            <!-- Navbar -->
            <header class="bg-white shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-semibold text-gray-800">Welcome, Student!</h1>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">
                        Log Out
                    </button>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-grow p-6 overflow-y-auto">
                <router-view />
            </main>
        </div>
    </div>
</template>

<script>
export default {
    name: "StudentDashboard",
};
</script>

<style scoped>
/* Add any scoped styles if needed */
</style>
