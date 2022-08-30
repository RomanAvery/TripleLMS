<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import Slideshow from '@/Components/Slideshow.vue';
</script>

<template>
    <GuestLayout title="Home">
        <div class="block relative overflow-hidden" v-if="images && images.length !== 0">
            <div class="inline-block h-4/6 lg:h-1/4 relative left-0 sm:left-1/2 lg:left-2/3">
                <Slideshow :images="images" :transition="1000" />
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
