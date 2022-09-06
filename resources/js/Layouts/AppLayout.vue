<script setup>
    import BaseLayout from '@/Layouts/BaseLayout.vue';
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Notifications from '@/Layouts/Notifications.vue';
//import Alerts from '@/Components/Alerts.vue';
import ResponsiveLinks from '@/Layouts/ResponsiveLinks.vue';
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
import JetBanner from '@/Jetstream/Banner.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import JetNavLink from '@/Jetstream/NavLink.vue';
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';

defineProps({
    title: String,
    fullHeight: {
        type: Boolean,
        default: false
    },
    hasSidebar: {
        type: Boolean,
        default: false
    },
});
</script>

<template>
    <BaseLayout :title="title" :fullHeight="fullHeight">
        <!-- Page Heading -->
        <template v-if="$slots.header" #heading>
            <slot name="header" />
        </template>

        <template #responsive-links>
            <ResponsiveLinks>
                <slot name="sidebar" />
            </ResponsiveLinks>
        </template>
        <slot />
    </BaseLayout>
</template>
