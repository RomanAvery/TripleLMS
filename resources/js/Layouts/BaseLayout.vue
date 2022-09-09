<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Notifications from '@/Layouts/Notifications.vue';
import Alerts from '@/Components/Alerts.vue';
import ResponsiveLinks from '@/Layouts/ResponsiveLinks.vue';
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
import JetBanner from '@/Jetstream/Banner.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import JetNavLink from '@/Jetstream/NavLink.vue';
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';

defineProps({
    title: {
        type: String,
        default: 'App',
    },
    fullHeight: {
        type: Boolean,
        default: false,
    }
});

const showingNavigationDropdown = ref(false);

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="`${title} - ${$page.props.settings.title}`" />

        <JetBanner />

        <div class="min-h-screen">
            <nav class="z-50 bg-white w-full" :class="{ 'relative': !fullHeight, 'absolute': fullHeight, 'md:fixed': fullHeight && !showingNavigationDropdown }">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
                    <div class="flex justify-between h-20">


                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('index')">
                                    <JetApplicationMark class="block h-14 w-auto" />
                                </Link>
                            </div>
                        </div>

                        <div class="flex md:hidden"></div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center">
                            <button class="inline-flex items-center justify-center p-2 rounded-full text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Page Heading -->
                <header v-if="$slots.heading" class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="heading" />
                    </div>
                </header>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                    class="relative h-full"
                >
                    <slot name="responsive-links" />
                </div>
            </nav>

            <Alerts />

            <!-- Page Content -->
            <main class="bg-gray-100" :class="{ 'hidden': showingNavigationDropdown, 'block': !showingNavigationDropdown }">
                <slot />
            </main>
        </div>
    </div>
</template>
