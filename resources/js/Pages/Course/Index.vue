<script setup>
    import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
    <app-layout :title="`Overview - ${course.name}`">
        <template #header>
            <ul>
                <li><Link class="text-blue-500 underline" :href="route('dashboard')">Home</Link> / Course: {{ course.name }} / Overview</li>
            </ul>
        </template>

        <section class="container m-auto mt-6 px-4 pb-6 w-full lg:w-1/2">
            <header class=" shadow rounded-lg p-8 md:h-48 sm:h-32  bg-cover"
                :style="`background-image: url('${course.coverPath}')`"
            >
                <div>
                    <h1 class="text-2xl text-white font-bold">
                        {{ course.name }} <span class="text-sm text-white">{{ course.code }}</span>
                    </h1>
                </div>
                <div class="mt-4" v-if="course.classLink !== null && course.classLink !== ''">
                    <a
                        :href="course.classLink"
                        target="_blank"
                        class="bg-white py-2 px-4 rounded-lg shadow"
                    >
                        Join Zoom Class
                    </a>
                </div>
            </header>

            <div class="my-4" v-if="course.description" v-html="course.description">
            </div>

            <hr class="py-2" />

            <h3 class="text-lg font-bold">Overview:</h3>

            <div v-if="course.topics && course.topics.length > 0" class="mt-6">
                <template :key="topic.id" v-for="topic in course.topics">
                    <Link
                        :href="( topic.numActivities === 0 ) ? '' : `/courses/topic/${topic.id}`"
                        v-if="topic.isShow"
                    >
                        <div
                            class="bg-white p-4 shadow rounded-lg mb-4"
                            :class="{ 'bg-gray-200': topic.numActivities === 0 }"
                        >
                            <span class="block">{{ topic.name }}</span>
                            <span class="text-sm">{{ topic.numActivities }} {{ pluralize('activity', topic.numActivities) }}</span>
                        </div>
                    </Link>
                </template>
            </div>

            <div v-else class="mt-6">
                <p class="text-md">This course doesn't have any content yet. Please check back later.</p>
            </div>
        </section>
    </app-layout>
</template>

<script>
    import pluralize from 'pluralize';
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
