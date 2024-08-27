<template>
    <div>
        <Navbar />
        <div class="page-container">
            <!-- Hero Section -->
            <section class="hero-section">
                <div class="hero-wrapper">
                    <div class="hero-content animated-element">
                        <Transition @before-enter="beforeEnterTitle" @enter="enterTitle">
                            <h1 v-if="showTitle" class="hero-title">
                                The Best Foreign Language & Technology Tutorials
                            </h1>
                        </Transition>

                        <Transition @before-enter="beforeEnterSubtitle" @enter="enterSubtitle">
                            <p v-if="showSubtitle" class="hero-subtitle">
                                And the easy way to learn The World
                            </p>
                        </Transition>

                        <Transition @before-enter="beforeEnterDescription" @enter="enterDescription">
                            <p v-if="showDescription" class="hero-description">
                                Select a track for a guided path through our 120+ video tutorial courses
                            </p>
                        </Transition>

                        <Transition @before-enter="beforeEnterButtons" @enter="enterButtons">
                            <div v-if="showButtons" class="hero-buttons">
                                <button class="btn-primary">Start Subscription</button>
                                <button class="btn-secondary">Browse Catalog</button>
                            </div>
                        </Transition>
                    </div>
                    <!-- Image/GIF alongside the content -->
                    <div class="hero-image animated-element">
                        <img :src="image" alt="Learning Screenshot" />
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="search-section animated-element">
                    <div class="search-title">
                        What are you going to learn next?
                    </div>
                    <div class="search-bar">
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search courses..."
                            class="input-field"
                        />
                        <button
                            @click="searchCourses"
                            :disabled="!searchQuery.trim()"
                            class="search-button"
                        >
                            Search
                        </button>
                    </div>
                </div>
            </section>

            <!-- Popular Courses Section -->
            <section class="popular-courses-section animated-element">
                <div class="container">
                    <h2 class="section-title">Popular Courses</h2>
                    <div class="courses-grid">
                        <div v-for="course in popularCourses" :key="course.id" class="course-card">
                            <img :src="course.thumbnail" :alt="course.title" class="course-image">
                            <h3 class="course-title">{{ course.title }}</h3>
                            <p class="course-description">{{ course.description }}</p>
                            <p class="course-price">${{ course.price }}</p>
                        </div>
                    </div>
                    <div class="see-all-courses">
                        <button class="see-all-button">See All Courses</button>
                    </div>
                </div>
            </section>

            <!-- Why Us Section -->
            <section class="why-us-section animated-element">
                <div class="container">
                    <h2 class="section-title">Why CourseApp.com?</h2>
                    <div class="features-grid">
                        <div v-for="feature in features" :key="feature.id" class="feature-item">
                            <svg
                                :class="feature.iconClass"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path :d="feature.iconPath" />
                            </svg>
                            <h3 class="feature-title">{{ feature.title }}</h3>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonials Section -->
            <section class="testimonials-section animated-element">
                <div class="container">
                    <h2 class="section-title">What People are Saying</h2>
                    <div class="testimonials-grid">
                        <div v-for="comment in comments" :key="comment.id" class="testimonial-item">
                            <p class="testimonial-text">"{{ comment.text }}"</p>
                            <p class="testimonial-author">{{ comment.author }}</p>
                        </div>
                    </div>
                    <div class="more-testimonials">
                        <a href="#" class="more-link">Not sure? Read some more testimonials</a>
                    </div>
                </div>
            </section>

            <!-- Call to Action Section -->
            <section class="cta-section animated-element">
                <div class="container">
                    <div class="cta-content">
                        <h2 class="cta-title">Build Something Awesome with Us</h2>
                        <div class="cta-details">
                            <p class="cta-description">
                                And do it faster with the help of our courses on Technology and more!
                            </p>
                            <button class="cta-button">Start Subscription</button>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <Footer />
    </div>
</template>

<script setup>
import Navbar from "@/Pages/Navbar.vue";
import imageUrl from '../../../storage/app/public/thumbnails/Screenshot 2024-08-27 124053.png';
import {onMounted, ref, watch} from "vue";
import { Inertia } from "@inertiajs/inertia";
import Footer from "../../../adminside/src/views/components/Footer.vue";
import Lenis from '@studio-freight/lenis'
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";


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
const features = ref([
    {
        id: 1,
        title: 'Challenges that help you learn faster',
        iconClass: 'icon-challenge',
        iconPath: 'M10 0L15.09 5L12 12H8L4.91 5L10 0z' // Replace with actual SVG path
    },
    {
        id: 2,
        title: 'Trusted by people like you',
        iconClass: 'icon-trusted',
        iconPath: 'M12 2L2 12h3v7h4v-5h2v5h4v-7h3L12 2z' // Replace with actual SVG path
    },
    {
        id: 3,
        title: 'Tutorials by experts',
        iconClass: 'icon-expert',
        iconPath: 'M10 0L15.09 5L12 12H8L4.91 5L10 0z' // Replace with actual SVG path
    },
    {
        id: 4,
        title: 'Guides downloads for each tutorial',
        iconClass: 'icon-guides',
        iconPath: 'M12 2L2 12h3v7h4v-5h2v5h4v-7h3L12 2z' // Replace with actual SVG path
    }
]);

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
                    markers: true,
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
        duration: 1,
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
        delay: 0.5,
        ease: "power3.out",
        onComplete: done,
    });
};

// Animation hooks for Description
const beforeEnterDescription = (el) => {
    el.style.opacity = 0;
    el.style.transform = "translateY(-10px)";
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

<style scoped>
    /* Popular Courses Section */
.popular-courses-section {
    padding: 124px 0;
    background-color: #f7fafc;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 16px;
}

.section-title {
    font-size: 2.25rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 32px;
    color: #1a202c;
}

.courses-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 32px;
}

@media (min-width: 768px) {
    .courses-grid {
        grid-template-columns: 1fr 1fr;
    }
}

@media (min-width: 1024px) {
    .courses-grid {
        grid-template-columns: 1fr 1fr 1fr 1fr;
    }
}

.course-card {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.course-card:hover {
    transform: translateY(-5px);
}

.course-image {
    width: 100%;
    border-radius: 6px;
    margin-bottom: 16px;
}

.course-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 12px;
    color: #2d3748;
}

.course-description {
    font-size: 1rem;
    color: #4a5568;
    margin-bottom: 16px;
}

.course-price {
    font-size: 1.125rem;
    font-weight: bold;
    color: #1a202c;
}

.see-all-courses {
    text-align: center;
    margin-top: 32px;
}

.see-all-button {
    background-color: #2b6cb0;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.see-all-button:hover {
    background-color: #2c5282;
}



/* Page Container */
.page-container {
    background-color: #f7fafc;
    min-height: 100vh;
}

/* Hero Section */
.hero-section {
    background-color: #1a202c;
    color: white;
    padding: 40px 16px;
}

.hero-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

@media (min-width: 640px) {
    .hero-wrapper {
        flex-direction: row;
        text-align: left;
    }
}

.hero-content {
    flex: 1;
    padding-right: 15px;
}

.hero-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 16px;
}

@media (min-width: 640px) {
    .hero-title {
        font-size: 3rem;
    }
}

.hero-subtitle {
    font-size: 1rem;
    font-weight: 300;
    margin-bottom: 16px;
}

.hero-description {
    font-size: 1rem;
    margin-bottom: 16px;
}

.hero-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 32px;
}

@media (min-width: 640px) {
    .hero-buttons {
        flex-direction: row;
    }
}

.btn-primary, .btn-secondary {
    padding: 10px 20px;
    font-weight: 600;
    cursor: pointer;
}

.btn-primary {
    background-color: #ecc94b;
    color: black;
}

.btn-primary:hover {
    background-color: #d69e2e;
}

.btn-secondary {
    background-color: white;
    color: #1a202c;
}

.btn-secondary:hover {
    background-color: #edf2f7;
}

/* Hero Image */
.hero-image {
    flex: 1;
    margin-top: 24px;
    display: block; /* Ensure the image is visible by default */
}

@media (min-width: 640px) {
    .hero-image {
        margin-top: 0;
    }
}

@media (max-width: 639px) {
    .hero-image {
        display: none; /* Hide the image on small screens */
    }
}

.hero-image img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
}

/* Search Section */
.search-section {
    padding: 20px 0;
    text-align: center;
}

.search-title {
    font-size: 1.25rem;
    color: #cbd5e0;
    margin-bottom: 12px;
}

.search-bar {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

@media (min-width: 640px) {
    .search-bar {
        flex-direction: row;
        justify-content: center;
    }
}

.input-field {
    padding: 10px;
    width: 100%;
    max-width: 400px;
    border-radius: 8px;
    border: 1px solid #cbd5e0;
}

.search-button {
    padding: 10px;
    background-color: #2b6cb0;
    color: white;
    border-radius: 8px;
    cursor: pointer;
}

.search-button:disabled {
    background-color: #a0aec0;
    cursor: not-allowed;
}


    /* Why Us Section */
    .why-us-section {
        background: linear-gradient(135deg, #ebf8ff 0%, #ddd8e7 100%); /* Light blue gradient */
        padding: 120px 0; /* Adjusted padding */
    }

    /* Container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 16px;
        text-align: center;
    }

    /* Section Title */
    .section-title {
        font-size: 2.25rem; /* Font size for the title */
        font-weight: bold;
        margin-bottom: 32px;
        color: #2a4365; /* Dark blue color for the title */
    }

    /* Features Grid */
    .features-grid {
        display: grid;
        grid-template-columns: 1fr; /* Single column by default */
        gap: 32px; /* Space between items */
    }

    @media (min-width: 768px) {
        .features-grid {
            grid-template-columns: 1fr 1fr; /* Two columns on medium screens */
        }
    }

    @media (min-width: 1024px) {
        .features-grid {
            grid-template-columns: 1fr 1fr 1fr 1fr; /* Four columns on large screens */
        }
    }

    /* Feature Item */
    .feature-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background-color: white; /* White background for each item */
        border-radius: 8px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    /* SVG Icons */
    .feature-item svg {
        width: 48px;
        height: 48px;
        margin-bottom: 16px;
        color: #2a4365; /* Dark blue color for icons */
    }

    /* Feature Title */
    .feature-title {
        font-size: 1.25rem; /* Font size for feature titles */
        font-weight: 600;
        color: #2d3748; /* Dark gray color for titles */
        margin-top: 12px;
    }


    /* Testimonials Section */
    .testimonials-section {
        padding: 94px 0;
        background-color: #f7fafc;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 16px;
        text-align: center;
    }

    .section-title {
        font-size: 2.25rem;
        font-weight: bold;
        margin-bottom: 32px;
        color: #2a4365;
    }

    /* Grid Layout */
    .testimonials-grid {
        display: grid;
        grid-template-columns: 1fr; /* Single column by default */
        gap: 32px;
    }

    /* Grid for Medium to Large Screens */
    @media (min-width: 768px) {
        .testimonials-grid {
            grid-template-columns: 1fr 1fr; /* Two columns on medium screens */
        }
    }

    @media (min-width: 1024px) {
        .testimonials-grid {
            grid-template-columns: 1fr 1fr 1fr; /* Three columns on large screens */
        }
    }

    .testimonial-item {
        background-color: white;
        padding: 24px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: left;
    }

    .testimonial-text {
        font-style: italic;
        color: #4a5568;
        margin-bottom: 16px;
    }

    .testimonial-author {
        font-weight: 600;
        color: #2d3748;
    }

    .more-testimonials {
        margin-top: 32px;
    }

    .more-link {
        color: #2a4365;
        text-decoration: underline;
        font-weight: 500;
    }

    .more-link:hover {
        color: #2c5282;
    }




    /* Call to Action Section with Gradient Background */
    .cta-section {
        background: linear-gradient(135deg, #2d3748, #4a5568, #2b6cb0); /* Gradient background */
        color: white; /* White text */
        padding: 120px 0;
        text-align: center;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 16px;
    }

    /* Flex container for title and description */
    .cta-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .cta-title {
        font-size: 2.9rem; /* Large text */
        font-weight: bold;
        margin-bottom: 16px;
    }

    .cta-details {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .cta-description {
        font-size: 1.25rem;
        margin-bottom: 32px;
        color: #e2e8f0; /* Light gray text for contrast */
    }

    .cta-button {
        padding: 12px 32px;
        font-size: 1rem;
        background-color: #ecc94b; /* Yellow button */
        color: black;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .cta-button:hover {
        background-color: #d69e2e;
    }

    /* Responsive Flexbox for Larger Screens */
    @media (min-width: 768px) {
        .cta-content {
            flex-direction: row;
            justify-content: space-between;
            text-align: left;
        }

        .cta-title {
            margin-right: 32px; /* Space between title and description */
            margin-bottom: 0; /* Remove bottom margin */
        }

        .cta-details {
            align-items: flex-start; /* Align description and button to the left */
        }
    }

</style>
