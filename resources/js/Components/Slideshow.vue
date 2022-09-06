<template>
    <section class="carousel" dir="ltr" aria-label="Gallery">
        <div id="slideshow-wrapper" class="relative w-full full-height">
            <div
                :key="image"
                v-for="image in images"
                class="absolute min-w-[100vw] object-cover full-height"
            >
                <img class="h-full w-full md:w-1/2 object-cover" :src="image" />
            </div>
        </div>
    </section>
</template>

<style scoped>
    .full-height {
        height: calc(100vh - 5rem);
    }
</style>

<script>
    import $ from 'jquery';

    export default {
        data() {
            return {
                timer: null,
            }
        },
        props: {
            delay: {
                default: 5000,
                type: Number,
            },
            images: {
                default: [],
                type: Array,
            },
            transition: {
                default: 300,
                type: Number,
            }
        },
        methods: {
            newImage() {
                let wrapper = $("#slideshow-wrapper");
                if (wrapper === null) return;

                let img = wrapper.children().last();
                let newImg = img.clone();

                img.fadeOut(this.transition, function() {
                    // Remove from end
                    img.remove();

                    // Add to front
                    wrapper.prepend(newImg);
                });
            }
        },
        mounted() {
            this.timer = setInterval(this.newImage, this.delay);
        },
        beforeUnmount() {
            clearInterval(this.timer);
        }
    }
</script>
