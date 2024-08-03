<template>
    <div>
        <ul class="space-y-2">
            <li>
                <router-link
                    to="/admin-dashboard"
                    class="block p-3 rounded-md border border-transparent text-gray-700
          hover:bg-blue-100 hover:border-blue-300 hover:text-blue-900 transition-all duration-300"
                >
                    Admin Dashboard Home
                </router-link>
            </li>
            <li>
                <router-link
                    to="/admin-dashboard/user-management"
                    class="block p-3 rounded-md border border-transparent text-gray-700
          hover:bg-blue-100 hover:border-blue-300 hover:text-blue-900 transition-all duration-300"
                >
                    User Management
                </router-link>
            </li>
            <li>
                <router-link
                    to="/admin-dashboard/content-management"
                    class="block p-3 rounded-md border border-transparent text-gray-700
          hover:bg-blue-100 hover:border-blue-300 hover:text-blue-900 transition-all duration-300"
                >
                    Content Management
                </router-link>
            </li>
            <li>
                <router-link
                    to="/admin-dashboard/site-settings"
                    class="block p-3 rounded-md border border-transparent text-gray-700
          hover:bg-blue-100 hover:border-blue-300 hover:text-blue-900 transition-all duration-300"
                >
                    Site Settings
                </router-link>
            </li>
            <li>
                <router-link
                    to="/admin-dashboard/analytics"
                    class="block p-3 rounded-md border border-transparent text-gray-700
          hover:bg-blue-100 hover:border-blue-300 hover:text-blue-900 transition-all duration-300"
                >
                    Analytics
                </router-link>
            </li>
            <li>
                <router-link
                    to="/admin-dashboard/support"
                    class="block p-3 rounded-md border border-transparent text-gray-700
          hover:bg-blue-100 hover:border-blue-300 hover:text-blue-900 transition-all duration-300"
                >
                    Support
                </router-link>
            </li>
            <li>
                <router-link
                    to="/admin-dashboard/security"
                    class="block p-3 rounded-md border border-transparent text-gray-700
          hover:bg-blue-100 hover:border-blue-300 hover:text-blue-900 transition-all duration-300"
                >
                    Security
                </router-link>
            </li>
            <li>
                <router-link
                    to="/admin-dashboard/customization"
                    class="block p-3 rounded-md border border-transparent text-gray-700
          hover:bg-blue-100 hover:border-blue-300 hover:text-blue-900 transition-all duration-300"
                >
                    Customization
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'AdminSidebarList',
    props: ['role']
};
</script>

<style scoped>
/* Scoped styles if needed */
</style>
