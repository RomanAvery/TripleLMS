<template>
    <div>
        <hr />
        <div class="py-2">
            <h1 class="text-90 font-normal text-2xl mb-3">
                Comments
            </h1>
        </div>

        <div class="card mb-6 py-4 px-6" v-if="!showReplies">
            <div>
                <button 
                    class="btn-outline-primary"
                    v-if="!addNew"
                    @click="addNew = true">+ Add New Comment</button>
                <button
                    class="btn-outline-danger" 
                    v-else
                    @click="addNew = false">- Hide Comment Form</button>
            </div>
            <div class="text-center shadow-md rounded-lg mb-4 p-4" v-if="addNew">
                <vue-editor v-model="comment" :editor-toolbar="customToolbar"  />

                <button
                    class="my-4 btn-outline-success"
                    v-if="comment != null  && comment != '' "
                    @click="saveComment()"
                >Add Comment</button>
            </div>

            <div :key="comment.id" v-for="comment in comments" class="mb-4 p-4 shadow-md rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink">
                        <img :src="comment.user.profile_photo_url" alt="" class="w-12 rounded-full">
                    </div>
                    <div class="ml-2 flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink">
                                <h2 class="text-90 text-sm">
                                    {{ comment.user.name }}
                                </h2>
                            </div>
                            <div class="text-xs  bg-gray-200 ml-2 px-2 py-2 rounded-lg">
                                {{ comment.created_at }}
                            </div>
                        </div>

                        <div v-html="comment.comment" class="mt-2"></div>

                        <div class="text-left">
                            <button class="mt-4"  @click="showComment(comment)">
                                <div class="flex items-center align-middle">
                                    <div class="flex-shrink">
                                        <svg class="w-6  text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                        </svg>
                                    </div>

                                    <div class="flex-1 ml-2  text-blue-600">
                                        Replies ({{ comment.totalReplies ?? 0 }})
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="flex-shrink" v-if="comment.user_id == user.id">
                        <button @click="deleteComment(comment)">
                            <svg class="w-4 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div v-else>
            <div class="mb-4 p-4 shadow-md rounded-lg bg-gray-100">
                <div
                    class="flex items-center"
                >
                    <div class="flex-shrink">
                        <img :src="comment.user.profile_photo_url" alt="" class="w-12 rounded-full">
                    </div>
                    <div class="ml-2 flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink">
                                <h2 class="text-90 text-sm">
                                    {{ comment.user.name }}
                                </h2>
                            </div>
                            <div class="text-xs  bg-gray-200 ml-2 px-2 py-2 rounded-lg">
                                {{ comment.created_at }}
                            </div>
                        </div>

                        <div v-html="comment.comment" class="mt-2"></div>

                        <div class="text-left">
                            <button class="mt-4" @click="returnToComments()">
                                <div class="flex items-center">
                                    <div class="flex-shrink">
                                        <svg class="w-6  text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </div>

                                    <div class="flex-1 ml-2  text-green-600">
                                        Back
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="flex-shrink" v-if="comment.user_id == user.id">
                        <button @click="deleteComment(comment)">
                            <svg class="w-4 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            <div :key="comment.id" v-for="comment in replies" class="mb-4 p-4  shadow-md rounded-lg bg-white border">
                <div
                    class="flex items-center"
                >
                    <div class="flex-shrink">
                        <img :src="comment.user.profile_photo_url" alt="" class="w-12 rounded-full">
                    </div>
                    <div class="ml-2 flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink">
                                <h2 class="text-90 text-sm">
                                    {{ comment.user.name }}
                                </h2>
                            </div>
                            <div class="text-xs  bg-gray-200 ml-2 px-2 py-2 rounded-lg">
                                {{ comment.created_at }}
                            </div>
                        </div>

                        <div v-html="comment.comment" class="mt-2"></div>
                    </div>

                    <div class="flex-shrink">
                        <button @click="deleteComment(comment)">
                            <svg class="w-4 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>


            <div class="text-center shadow-md rounded-lg  mb-4 p-4 bg-white">
                <h2 class="text-90 text-sm mb-4 text-left">Respond:</h2>
                <vue-editor v-model="reply" :editor-toolbar="customToolbar"  />

                <button
                    class="my-4 btn-outline-success"
                    v-if="reply != null  && reply != ''"
                    @click="saveReply()"
                >Save Reply</button>
            </div>
        </div>

    </div>
</template>

<script>
    import { Inertia } from '@inertiajs/inertia';
    import { VueEditor } from "vue3-editor";

    export default {
        props: {
            activity: Object,
            user: Object
        },

        components: { VueEditor },

        data: function () {
            return {
                addNew: false,
                comment: null,
                comments: Object,
                showReplies: false,
                reply: null,
                replies: Object,
                customToolbar: [
                    ['font' ,"bold", "italic", "underline"],
                    [{ list: "ordered" }, { list: "bullet" }],
                ]
            }
        },

        computed: {

        },

        mounted() {
            this.getComments()
        },

        methods: {
            getComments: function () {
                axios.get(route('comments.list', [this.activity.id])).then(response => {
                    this.comments = response.data
                })
            },

            saveComment: function () {
                let data = {
                    'activityId': this.activity.id,
                    'comment': this.comment,
                };

                axios.post(route('comments.store', [this.activity.id]), data).then(response => {
                    this.comments.unshift(response.data)
                });

                this.addNew = false;
                this.comment = '';
            },

            deleteComment: function (comment) {
                this.comments = this.comments.filter(item => item.id != comment.id)
                axios.delete(route('comments.delete', [comment.id]));
            },

            showComment: function (comment) {
                this.comment = comment
                this.showReplies = true
                this.getReplies()
            },

            returnToComments: function () {
                this.comment = null
                this.showReplies = false
                this.replies = Object
            },

            getReplies: function () {
                axios.get(route('comments.replies', [this.activity.id, this.comment.id])).then(response => {
                    this.replies = response.data
                })
            },

            saveReply: function () {
                let data = {
                    'activityId': this.activity.id,
                    'comment': this.reply,
                    'parent_id': this.comment.id
                }

                axios.post(route('comments.storeReply', [this.activity.id, this.comment.id]), data).then(response => {
                    this.replies.push(response.data)
                })

                this.reply = ''
            },

        }
    }
</script>
