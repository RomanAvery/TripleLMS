<script setup>
import { Link } from '@inertiajs/inertia-vue3'
</script>

<template>
    <ul class="py-4 border-t border-gray-200">
        <template :key="t.id" v-for="t in topics">
            <li class="p-2"
                :class="{ 'bg-gray-200 cursor-pointer': t.numActivities === 0 }">
                <Link v-if="t.numActivities !== 0" :href="route('courses.topic', t.id)">
                    <h3 class="text-md" :class="{ 'font-bold' : topic.id === t.id }">{{ t.name }}</h3>
                </Link>
                <div v-else>
                    <h3 class="text-md">{{ t.name }}</h3>
                </div>

                <ul v-if="topic.id === t.id && topic.activities">
                    <template
                    :key="act.id"
                    v-for="act in topic.activities"
                    >
                        <li
                            class="cursor-pointer"
                            v-show="act.isShow == 1"
                        >
                            <Link
                                :href="route('courses.topic', [topic.id, act.id])"
                                class="p-2 w-full hover:bg-gray-200 inline-block"
                                :class="{ 'active-activity': act.id === activity.id }"
                            >
                                <span class="inline-block pr-2" style="height:18px;" v-html="icons[act.type]"></span>
                                <!--<span v-if="t.completed">&#9745;</span>-->
                                {{ act.name }}
                            </Link>
                        </li>
                    </template>
                </ul>
            </li>
        </template>
    </ul>
</template>

<script>
export default {
    props: {
        topic: Object,
        topics: Object,
        icons: Object,
        activity: Object,
    }
}
</script>
