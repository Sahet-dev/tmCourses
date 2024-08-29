<template>
    <div>
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


const image = imageUrl;
const searchQuery = ref('');
const transitionsCompleted = ref(0);
const totalTransitions = 4;

// Sample data for popular courses
const popularCourses = ref([
    {
        id: 1,
        title: 'Learn Web Development',
        description: 'Master the basics of HTML, CSS, and JavaScript.',
        price: 49.99,
        thumbnail: 'path/to/image1.jpg',
    },
    {
        id: 2,
        title: 'Advanced JavaScript',
        description: 'Deep dive into JavaScript ES6+ features.',
        price: 59.99,
        thumbnail: 'path/to/image2.jpg',
    },{
        id: 2,
        title: 'Advanced JavaScript',
        description: 'Deep dive into JavaScript ES6+ features.',
        price: 59.99,
        thumbnail: 'path/to/image2.jpg',
    },{
        id: 2,
        title: 'Advanced JavaScript',
        description: 'Deep dive into JavaScript ES6+ features.',
        price: 59.99,
        thumbnail: 'path/to/image2.jpg',
    },
    // Add more course data as needed...
]);
// Search function
const searchCourses = () => {
    Inertia.get(route('courses.search'), { search: searchQuery.value }, {
        preserveState: true,
        replace: true,
    });
};

// Sample data for the "Why Us" features

// Sample comments data
const comments = ref([
    { id: 1, text: 'This platform has changed the way I learn. The tutorials are spot on.', author: 'Jane Doe' },
    { id: 2, text: 'Amazing content and great instructors!', author: 'John Smith' },
    { id: 3, text: 'Highly recommend for anyone looking to upskill.', author: 'Alice Johnson' }
]);




onMounted(() => {
    gsap.utils.toArray('.animated-element').forEach((element) => {
        gsap.fromTo(
            element,
            { opacity: 0, y: 100 },
            {
                opacity: 1,
                y: 0,
                duration: 1.2,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: element,
                    start: 'top 95%',
                    end: 'bottom 70%',
                    scrub: true,
                    markers: false,
                },
            }
        );
    });
});



// Refs to control visibility of elements
const showTitle = ref(false);
const showSubtitle = ref(false);
const showDescription = ref(false);
const showButtons = ref(false);

// Animation hooks for Title
const beforeEnterTitle = (el) => {
    el.style.opacity = 0;
    el.style.transform = "translateY(-30px)";
};

const enterTitle = (el, done) => {
    gsap.to(el, {
        opacity: 1,
        y: 0,
        duration: 2,
        ease: "power3.out",
        onComplete: done,
    });
};

// Animation hooks for Subtitle
const beforeEnterSubtitle = (el) => {
    el.style.opacity = 0;
    el.style.transform = "translateY(-20px)";
};

const enterSubtitle = (el, done) => {
    gsap.to(el, {
        opacity: 1,
        y: 0,
        duration: 1,
        delay: 1,
        ease: "power3.out",
        onComplete: done,
    });
};

// Animation hooks for Description
const beforeEnterDescription = (el) => {
    el.style.opacity = 0;
    el.style.transform = "translateY(-50px)";
};

const enterDescription = (el, done) => {
    gsap.to(el, {
        opacity: 1,
        y: 0,
        duration: 1,
        delay: 1,
        ease: "power3.out",
        onComplete: done,
    });
};

// Animation hooks for Buttons
const beforeEnterButtons = (el) => {
    el.style.opacity = 0;
    el.style.transform = "translateY(0px)";
};

const enterButtons = (el, done) => {
    gsap.to(el, {
        opacity: 1,
        y: 0,
        duration: 1,
        delay: 1.5,
        ease: "power3.out",
        onComplete: done,
    });
};

// When each transition completes
const onTransitionComplete = () => {
    transitionsCompleted.value += 1;
};

// Watch for completion of all transitions
watch(transitionsCompleted, (newVal) => {
    if (newVal === totalTransitions) {
        // Refresh ScrollTrigger after all transitions are done
        ScrollTrigger.refresh();
    }
});



// Show elements sequentially after mounting
onMounted(() => {
    showTitle.value = true;
    showSubtitle.value = true;
    showDescription.value = true;
    showButtons.value = true;
});


</script>


