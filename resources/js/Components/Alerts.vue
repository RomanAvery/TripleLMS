<template>
    <div class="p-2 w-full flex justify-between" :class="bgClass()" v-if="message() && show">
        <span>{{ message() }}</span>
        <span class="cursor-pointer" @click="show = false">&cross;</span>
    </div>
</template>

<script>
    import { ref } from 'vue';
    import { usePage } from '@inertiajs/inertia-vue3';

    export default {
        data() {
            return {
                show: ref(true),
            }
        },
        computed: {
            error() {
                return usePage().props.value.flash.error;
            },
            info() {
                return usePage().props.value.flash.info;
            },
            success() {
                return usePage().props.value.flash.success;
            }
        },
        methods: {
            bgClass() {
                if (this.error) return 'bg-red-400';
                if (this.info) return 'bg-blue-400';
                if (this.success) return 'bg-green-400';
            },
            message() {
                if (this.error) return this.error;
                if (this.info) return this.info;
                if (this.success) return this.success;

                return null;
            }
        },
    };
</script>
