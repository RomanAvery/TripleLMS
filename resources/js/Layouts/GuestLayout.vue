<script setup>
    import BaseLayout from '@/Layouts/BaseLayout.vue';
    import ResponsiveLinks from '@/Layouts/ResponsiveLinks.vue';
defineProps({
    title: String,
});
</script>

<template>
    <BaseLayout :title="title">
        <template #responsive-links>
            <ResponsiveLinks />
        </template>

        <slot />
    </BaseLayout>
</template>
