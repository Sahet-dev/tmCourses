<template>
    <div>
        <Navbar />

        <!-- Render GuestPage if the user is not logged in -->
        <div v-if="!$page.props.auth || !$page.props.auth.user">
            <GuesPage />
        </div>

        <!-- Render UserPage if the user is logged in -->
        <div v-else>
            <UserPage />
        </div>
    </div>
</template>

<script setup>
import Navbar from "@/Pages/Navbar.vue";
import '../../css/mainPage.css'
import Lenis from '@studio-freight/lenis'
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import GuesPage from "@/Pages/components/GuestPage.vue";
import UserPage from "@/Pages/components/UserPage.vue";


gsap.registerPlugin(ScrollTrigger);

const lenis = new Lenis()

lenis.on('scroll', (e) => {
    // console.log(e)
})

function raf(time) {
    lenis.raf(time)
    requestAnimationFrame(raf)
}

requestAnimationFrame(raf)











</script>


