<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="p-4">
        <h1 class="text-xl font-semibold pb-2">
            <span class="font-bold">{{ status }}</span>
            <span>: {{ title }}</span>
        </h1>
        <p>{{ description }}</p>
    </div>
    <div class="p-4">
        <h3 class="text-lg font-semibold">Links:</h3>
        <ul class="list-disc pl-6 child-hover:underline">
            <li>
                <Link :href="route('index')">Home</Link>
            </li>

            <template v-if="$page.props.user">
                <li><Link :href="route('courses.index')">Courses</Link></li>
                <li><Link :href="route('awards')">Awards</Link></li>
                <li><Link :href="route('profile.show')">Profile</Link></li>
            </template>
            <template v-else>
                <li><Link :href="route('login')">Login</Link></li>
                <li><Link :href="route('register')">Register</Link></li>
            </template>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            status: Number
        },
        computed: {
        title() {
            return {
                503: 'Service Not Available',
                500: 'Error',
                403: 'Access Refused',
                404: 'Not Found',
            } [this.status]
        },
        description() {
            return {
                503: "Sorry, we are doing some maintenance. Please come back later.",
                500: 'Oops, an error occured!',
                403: "Sorry, you are not allowed to access this content.",
                404: "We're really sorry, but we can't find what you wanted."
            } [this.status]
        },
    },
    }
</script>
