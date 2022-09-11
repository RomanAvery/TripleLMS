<template>
    <div>
        <div class="activity-header flex items-center">
            <div class="flex-1">
                <h1 class="text-2xl text-gray-800">
                    {{ activity.name }}
                </h1>
            </div>
        </div>

        <div class="my-4">
            <div v-if="user.survey_opt_in" id="qualtrics-content">
                <iframe
                    v-if="qualtricsLink !== null"
                    :src="qualtricsLink"
                ></iframe>
                <iframe 
                    v-else-if="this.activity.activityable.allow_generic_link"
                    :src="`${this.activity.activityable.link}?name=${this.user.name}&email=${this.user.email}`"
                ></iframe>
                <div v-else class="mx-4">
                    <p>This survey is opt-in only.</p>
                    <p>If you'd like to join, please ask your teacher.</p>
                    <p>Otherwise, you can continue.</p>
                </div>
            </div>
                
            <div v-else class="mx-4">
                <p>You haven't opted in to any surveys.</p>
                <p>If you'd like to, please ask your teacher.</p>
                <p>Otherwise, you can continue.</p>
            </div>
        </div>

        <comments :activity="activity" :user="user"></comments>
    </div>
</template>

<script>
    import $ from 'jquery';
    import pym from 'pym.js';
    import Comments from "../Comments.vue";

    export default {
        components: {
            Comments,
        },

        props: {
            activity: Object,
            user: Object,
            qualtricsLink: String,
        },

        mounted() {
            if (this.user.survey_opt_in) {
                //new pym.Parent('qualtrics-content', `${this.activity.activityable.link}?name=${this.user.name}&email=${this.user.email}`);
            }
        },
    }
</script>

<style scoped>
    #qualtrics-content iframe {
        width: 100%;
        height: 950px;
    }
</style>
