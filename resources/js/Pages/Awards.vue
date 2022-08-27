<script setup>
    import AppLayout from '../Layouts/AppLayout.vue';
    import Award from '@/Components/Award.vue';
</script>

<template>
    <AppLayout title="Awards">
        <div class="container m-auto my-6 pb-6 px-6 flex flex-col md:flex-row items-center justify-between bg-white shadow-lg">
            <div v-if="awards !== null && awards.length !== 0">
                <h1 class="text-lg font-bold pb-4">Your Awards</h1>
                <hr class="pb-4" />

                <div class="grid grid-cols-2 md:grid-cols-3">
                    <template :key="award.id" v-for="award in awards">
                        <Award :award="award" />
                    </template>
                </div>
            </div>
            <div v-else>
                <h1 class="text-xl">You don't have any awards yet.</h1>
                <p>Finish a course to earn one.</p>
            </div>
        </div>
    </AppLayout>
</template>

<script>
    export default {
        components: {
            AppLayout,
        },

        props: {
            awards: Array
        },
    }
</script>
