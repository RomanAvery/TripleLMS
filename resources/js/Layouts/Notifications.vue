<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="flex relative">
        <button class="flex text-sm border-2 border-transparent pt-1 my-4" @click="toggleShowNotification()">
            <svg data-v-f76a318a="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="text-90 fill-gray-500 hover:fill-gray-700 w-6 h-6">
                <path data-v-f76a318a="" d="M15 19a3 3 0 0 1-6 0H4a1 1 0 0 1 0-2h1v-6a7 7 0 0 1 4.02-6.34 3 3 0 0 1 5.96 0A7 7 0 0 1 19 11v6h1a1 1 0 0 1 0 2h-5zm-4 0a1 1 0 0 0 2 0h-2zm0-12.9A5 5 0 0 0 7 11v6h10v-6a5 5 0 0 0-4-4.9V5a1 1 0 0 0-2 0v1.1z"></path>
            </svg>
        </button>

        <div class="w-screen absolute z-50 rounded-md shadow-lg origin-top-right my-12" v-if="isShow">
            <div class="shadow-lg border-gray-900 bg-white mt-2 rounded-lg" style="width: 600px">
                <div class="flex justify-between bg-gray-200 py-2 px-2">
                    <div>
                        <h1 class="text-lg font-bold">Notifications</h1>
                    </div>
                    <div>
                        <button @click="clearNotifications" class="text-md font-bold">
                            Mark all as read
                        </button>
                    </div>
                </div>
                <div :key="notification.id" v-for="notification in notifications" class="mx-4 mt-2">
                    <Link :href="route('courses.topic', [notification.data.topic_id, notification.data.activity_id])">
                        <h2 class="text-lg text-blue-500 font-bold">{{ notification.data.info }}</h2>
                    </Link>
                    <div class="border-t border-gray-100" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                notifications: Object,
                isShow: false
            }
        },

        mounted() {
            axios.get(route('notifications.list')).then(response => {
                this.notifications = response.data
            });
        },

        methods: {
            toggleShowNotification: function() {
                if(this.isShow) {
                    return this.isShow = false
                }

                this.isShow = true
            },

            clearNotifications() {
                axios.delete(route('notifications.delete'));
                this.notifications = {};
            }
        }
    }
</script>

<style scoped>

</style>
