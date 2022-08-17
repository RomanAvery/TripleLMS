<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
</script>

<template>
    <GuestLayout title="Home">
        <div class="block relative overflow-hidden" v-if="images && images.length !== 0">
            <div class="inline-block h-4/6 relative left-0 sm:left-1/2 lg:left-1/3">
                <Carousel :autoplay="4000" :wrap-around="true" :mouseDrag="false" :touchDrag="false">
                    <Slide v-for="slide in images" :key="slide">
                        <div class="carousel__item">
                            <img :src="slide" />
                        </div>
                    </Slide>
                </Carousel>
            </div>
            <div class="w-1/2 absolute inset-x-1/4 inset-y-1/4">
                <img class="w-full bg-gray-50 py-2 rounded-md" v-if="brand" :src="brand" />
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
            brand() {
                return usePage().props.value.settings.brand;
            }
        },
        mounted() {
            console.log(usePage())
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
