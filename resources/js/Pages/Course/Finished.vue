<script setup>
    import { Link } from "@inertiajs/inertia-vue3";
    import Award from '@/Components/Award.vue';
</script>

<template>
    <app-layout :title="`Overview - ${course.name}`">
        <template #header>
            <ul>
                <li><Link class="text-blue-500 underline" :href="route('courses.index')">Home</Link> / Course: {{ course.name }} / Finished</li>
            </ul>
        </template>

        <div class="container m-auto my-6 pb-6 flex flex-col md:flex-row items-center justify-between bg-white shadow-lg">
            <h1 class="text-lg">Congratulations, you completed {{ course.name }}!</h1>
            <template v-if="course.award !== null">
                <p>You also earned this badge:</p>
                <div class="w-1/3">
                    <Award :award="course.award" />
                </div>
            </template>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout.vue'

    export default {
        components: {
            AppLayout,
        },

        props: {
            course: Object
        }
    }
</script>

<style scoped>

</style>
