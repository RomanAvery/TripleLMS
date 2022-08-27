<script setup>
import AppWithSidebarLayout from '@/Layouts/AppWithSidebarLayout.vue';
import { Link } from '@inertiajs/inertia-vue3'
</script>

<template>
    <AppWithSidebarLayout
        :title="topic.name"
        :topic="topic"
        :topics="topics"
        :activity="activity"
        :fullHeight="true"
    >
        <div class="max-w-7xl mx-auto md:px-6 lg:px-8">
            <div class="md:p-4 bg-white shadow-xl sm:rounded-lg">

                <div v-if="!activity">
                    <h1 class="text-2xl text-gray-800">
                        You don't have activities yet
                    </h1>
                    <hr>
                </div>

                <div v-else class="pb-4 mb-8 container m-auto bg-white shadow rounded-lg"><!-- overflow-scroll">-->
                    <exercise-activity v-if="activity.type == 'EXERCISE'" :activity="activity" :user="user"></exercise-activity>

                    <h5p-activity v-if="activity.type == 'H5P'" :activity="activity" :user="user" />

                    <qualtrics-activity v-if="activity.type == 'QUALTRICS'" :activity="activity" :user="user" />

                    <make-code-activity v-if="activity.type == 'MAKECODE'" :activity="activity" :user="user" />

                    <text-activity v-if="activity.type == 'TEXT'" :activity="activity" :user="user"></text-activity>

                    <video-grid-activity v-if="activity.type == 'VIDEO_GRID'" :activity="activity" :user="user" />
                </div>


                <div class="flex justify-between">
                    <Link class="btn-outline-primary" :href="prev_url" v-if="prev_url">&lt; Prev</Link>
                    <div v-else></div>

                    <Link class="btn-outline-primary" :href="next_url" v-if="next_url">Next &gt;</Link>
                    <Link class="btn-outline-success" :href="route('courses.finish', topic.course.id)" v-else-if="prev_url && !next_url">Finish Course</Link>
                    <div v-else></div>
                </div>
            </div>
        </div>
    </AppWithSidebarLayout>
</template>

<script>
    import { pageview, event } from 'vue-gtag';

    import ExerciseActivity from "./Activities/Exercise.vue";
    import H5pActivity from './Activities/H5p.vue';
    import QualtricsActivity from './Activities/Qualtrics.vue';
    import MakeCodeActivity from './Activities/MakeCode.vue';
    import TextActivity from './Activities/Text.vue';
    import VideoGridActivity from './Activities/VideoGrid.vue';
    import Comments from "./Comments.vue";

    export default {
        components: {
            H5pActivity,
            QualtricsActivity,
            ExerciseActivity,
            MakeCodeActivity,
            TextActivity,
            VideoGridActivity,
            Comments,
        },

        props: {
            topic: Object,
            topics: Object,
            activity: Object,
            user: Object,
        },

        track() {
            pageview('test');
            event("view_topic", {
                'event_category': "general",
                'event_label': "View a topic",
                'value': this.topic.id,
            });
        },

        data: () => {
          return {
              open: false,
              dimmer: true,
              right: false,
              prev_url: null,
              next_url: null,
          }
        },

        created() {
            window.addEventListener('beforeunload', this.save_analytics);
        },

        mounted() {
            this.getNav();
            console.log(this.topic);
            console.log(this.activity);
        },

        methods: {
            toggle() {
                this.open = !this.open;
            },

            save_analytics(evt) {
                /*console.log(evt);
                evt.returnValue = false;
                alert('Test');
                return false;*/
            },

            getNav: function() {
                if (!this.activity.id) return;

                axios.get(route('nav.topic.activity', this.activity.id)).then(response => {
                    if (response.data.prev != null) {
                        this.prev_url = route('courses.topic', [response.data.prev?.topic_id ?? this.topic.id, response.data.prev.id]);
                    }

                    if (response.data.next != null) {
                        this.next_url = route('courses.topic', [response.data.next?.topic_id ?? this.topic.id, response.data.next.id]);
                    }
                    //this.comments = response.data
                })
            },
        }
    }
</script>

<style>

html {
    background: #efefef;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 1s ease-out;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
.pulse {
    background: rgba(51, 217, 178, 1);
    box-shadow: 0 0 0 0 rgba(51, 217, 178, 1);
    animation: pulse-green 2s infinite;
}

@keyframes pulse-green {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(51, 217, 178, 0.7);
    }

    70% {
        transform: scale(1);
        box-shadow: 0 0 0 10px rgba(51, 217, 178, 0);
    }

    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(51, 217, 178, 0);
    }
}

.active-activity {
    background-color: #F4F5F7;
    border-bottom: #0d826c solid 2px;
}

.active-activity{
    color:#0d826c;
    font-weight: bold;
}

.active-activity svg{
    color: #0d826c;
}
</style>
