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
import imageUrl from '../../../storage/app/public/thumbnails/Screenshot 2024-08-27 124053.png';
import {onMounted, ref, watch} from "vue";
import { Inertia } from "@inertiajs/inertia";
import Footer from "../../../adminside/src/views/components/Footer.vue";
import Lenis from '@studio-freight/lenis'
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import Icons from "@/Components/Icons.vue";
import GuesPage from "@/Pages/components/GuesPage.vue";
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


