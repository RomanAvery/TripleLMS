<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import ErrorContent from '@/Components/ErrorContent.vue';
</script>

<template>
    <AppLayout v-if="$page.props.user">
        <ErrorContent :status="status" />
    </AppLayout>
    <GuestLayout v-else>
        <ErrorContent :status="status" />
    </GuestLayout>
</template>

<script>
    export default {
        props: {
            status: Number
        }
    }
</script>
