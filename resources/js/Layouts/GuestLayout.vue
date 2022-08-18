<script setup>
    import BaseLayout from '@/Layouts/BaseLayout.vue';
    import JetNavLink from '@/Jetstream/NavLink.vue';
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';

defineProps({
    title: String,
});
</script>

<template>
    <BaseLayout :title="title">
        <template #responsive-links>
            <div class="pt-2 pb-3 space-y-1">
                <JetResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Student
                </JetResponsiveNavLink>
                <hr class="mx-4 border-b-1 border-gray-400" />
                <JetResponsiveNavLink :href="route('nova.pages.home')">
                    Teacher Login
                </JetResponsiveNavLink>
            </div>
        </template>

        <slot />
    </BaseLayout>
</template>