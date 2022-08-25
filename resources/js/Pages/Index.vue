<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
</script>

<template>
    <GuestLayout title="Home">
        <div class="block relative overflow-hidden" v-if="images && images.length !== 0">
            <div class="inline-block h-4/6 lg:h-1/4 relative left-0 sm:left-1/2 lg:left-2/3">
                <Carousel :autoplay="4000" :wrap-around="true" :mouseDrag="false" :touchDrag="false">
                    <Slide v-for="slide in images" :key="slide">
                        <div class="carousel__item">
                            <img class="h-full w-auto md:w-1/2" :src="slide" />
                        </div>
                    </Slide>
                </Carousel>
            </div>
            <div class="w-1/2 absolute inset-x-1/4 inset-y-1/4">
                <img class="w-full rounded-md" :class="{ 'feature-image': featuredImageBackground }" v-if="brand" :src="brand" />
                <div class="w-1/2" v-if="content && content.featured" v-html="content.featured">
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="py-6" v-html="content?.main" />
        </div>
    </GuestLayout>
</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'

    export default {
        computed: {
            featuredImageBackground() {
                let b = usePage().props.value.settings.featured_image_background;
                return (b === true || b === "1") ? true : false;
            },
            brand() {
                return usePage().props.value.settings.brand;
            }
        },
        props: {
            content: Array,
            images: Array,
        },
    }
</script>

<style>
    @import 'vue3-carousel/dist/carousel.css';
    .carousel__prev {
        transform: translate(20%, -50%);
    }

    .carousel__next {
        transform: translate(-20%, -50%);
    }
</style>
