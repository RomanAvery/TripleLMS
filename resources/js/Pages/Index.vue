<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
</script>

<template>
    <GuestLayout title="Home">
        <div v-if="images && images.length !== 0">
            <Carousel :autoplay="4000" :wrap-around="true">
                <Slide v-for="slide in images" :key="slide">
                    <div class="carousel__item">
                        <img :src="slide" />
                    </div>
                </Slide>

                <template #addons>
                    <Navigation />
                </template>
            </Carousel>
        </div>

        <div class="p-6">
            <div v-if="content && content.columns" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <template :key="index" v-for="(column, index) in content.columns">
                    <div class="rounded bg-gray-300 p-4" v-html="column" />
                </template>
            </div>

            <div class="py-6" v-html="content?.main" />
        </div>
    </GuestLayout>
</template>

<script>
    export default {
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
