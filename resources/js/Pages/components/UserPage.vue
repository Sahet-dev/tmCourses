<template>
    <div>
        <div class="min-h-screen bg-gradient-to-r from-gray-100 via-pink-50 to-blue-50 ">
            <header class="bg-gradient-to-r from-blue-200 via-purple-100 to-pink-200 shadow-md">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div id="navbar" class=" p-2">


                        <div class="flex space-x-8">
                            <router-link to="/" class="flex items-center   ">
                                <div v-if="$route.path === '/'">
                                    <PresentationChartLineIconSolid class="w-5 h-5 "/>
                                </div>
                                <div v-else>
                                    <PresentationChartLineIcon class="w-5 h-5  " />
                                </div>
                                <span class="hidden md:block ml-2">Activity</span>

                            </router-link>

                            <router-link to="/account" class="flex items-center   ">
                                <div v-if="$route.path === '/account'">
                                    <UserIconSolid class="w-5 h-5 "/>
                                </div>
                                <div v-else>
                                    <UserIcon class="w-5 h-5  " />
                                </div>
                                <span class="hidden md:block ml-2">Account</span>

                            </router-link>

                            <router-link to="/bookmarks" class="flex items-center   ">
                                <div v-if="$route.path === '/bookmarks'">
                                    <BookmarkIconSolid class="w-5 h-5 "/>
                                </div>
                                <div v-else>
                                    <BookmarkIcon class="w-5 h-5  " />
                                </div>
                                <span class="hidden md:block ml-2">Bookmarks</span>

                            </router-link>

                            <router-link to="/completed" class="flex items-center   ">
                                <div v-if="$route.path === '/completed'">
                                    <CheckBadgeIconSolid class="w-5 h-5 "/>
                                </div>
                                <div v-else>
                                    <CheckBadgeIcon class="w-5 h-5  " />
                                </div>

                                <span class="hidden md:block  ml-2">Completed</span>

                            </router-link>
                        </div>
                    </div>

                </div>
            </header>

            <main>
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 ">
                    <!-- Notification List -->
                    <div class="">
                        <router-view v-slot="{ Component }">
                            <transition name="route" mode="out-in">
                                <component :is="Component"></component>
                            </transition>
                        </router-view>
                    </div>
                </div>
            </main>
        </div>

    </div>
</template>


<script setup>

import {defineProps, onMounted} from 'vue';
import Navbar from "@/Pages/Navbar.vue";
import { beforeEnterEl, enterEl, lenis } from '@/utils/animations';
import {UserIcon, BookmarkIcon, CheckBadgeIcon,  PresentationChartLineIcon} from "@heroicons/vue/24/outline/index.js";
import {UserIcon as UserIconSolid, BookmarkIcon as BookmarkIconSolid, CheckBadgeIcon as CheckBadgeIconSolid, PresentationChartLineIcon as PresentationChartLineIconSolid} from "@heroicons/vue/24/solid";


// Define props
const props = defineProps(
    {notifications: Array,}
);
const notifications = props.notifications;



function markAsRead(id) {
    // Logic to mark notification as read
    console.log(`Notification ${id} marked as read`);
}

onMounted(() => {
    const elements = document.querySelectorAll('.animate-element');

    elements.forEach((el, index) => {
        // Trigger animations for each element with staggered delay
        beforeEnterEl(el);
        enterEl(el, () => {
            // console.log('Animation complete');
        }, index);
    });

    // Lenis scroll usage if needed
    lenis.on('scroll', (e) => {
        // console.log('Scrolled:', e);
    });
});
</script>

<style scoped>


#navbar a {
    font-weight: bold;
    color: #e49e58;
}
#navbar a.router-link-exact-active {
    color: #5daeec;
    text-decoration: none; /* Remove text underline */
    border-bottom: 2px solid #5daeec; /* Add border to the bottom */
    padding-bottom: 2px;
}

.route-enter-from{
    opacity: 0;
    transform: translateX(100px);
}
.route-enter-active{
    transition: all 0.3s ease-out;
}
.route-leave-to{
    opacity: 0;
    transform: translateX(-100px);
}
.route-leave-active{
    transition: all 0.3s ease-out;
}

</style>
