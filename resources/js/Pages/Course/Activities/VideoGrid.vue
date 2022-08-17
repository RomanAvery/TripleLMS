<template>
    <div>
        <div class="activity-header flex items-center">
            <div class="flex-1">
                <h1 class="text-2xl text-gray-800">
                    {{ activity.name }}
                </h1>
            </div>
        </div>

        <div class="my-4 grid grid-cols-1 lg:grid-cols-2">
            <iframe 
                :key="video" 
                v-for="video in activity.activityable.videos"
                :src="video"
            />
        </div>

        <comments :activity="activity" :user="user"></comments>
    </div>
</template>

<script>
    import $ from 'jquery';
    import Comments from "../Comments.vue";

    export default {
        components: {
            Comments,
        },

        props: {
            activity: Object,
            user: Object,
        },
    }
</script>

<style scoped>

</style>
