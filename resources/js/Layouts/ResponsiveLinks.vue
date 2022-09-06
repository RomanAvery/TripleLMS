<script setup>
    import { Inertia } from '@inertiajs/inertia';
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';

    const logout = () => {
        Inertia.post(route('logout'));
    };
</script>

<template>
    <div class="pt-2 pb-1 space-y-1">
        <JetResponsiveNavLink :href="route('index')" :active="route().current('index')">
            Home
        </JetResponsiveNavLink>
        <template v-if="$page.props.user">
            <JetResponsiveNavLink :href="route('courses.index')" :active="route().current('courses.index')">
                Courses
            </JetResponsiveNavLink>
            <JetResponsiveNavLink :href="route('awards')" :active="route().current('awards')">
                Awards
            </JetResponsiveNavLink>
            <hr class="border-t border-gray-200" />
            <JetResponsiveNavLink :href="route('nova.login')" :active="route().current('nova.login')">
                Teacher Area
            </JetResponsiveNavLink>
        </template>
        <template v-else>
            <hr class="border-t border-gray-200" />
            <JetResponsiveNavLink :href="route('login')" :active="route().current('login')">
                Login
            </JetResponsiveNavLink>
            <JetResponsiveNavLink :href="route('register')" :active="route().current('register')">
                Register
            </JetResponsiveNavLink>
        </template>
    </div>

    <!-- Slot for sidebar content -->
    <slot />

    <!-- Responsive Settings Options -->
    <div v-if="$page.props.user" class="pt-3 pb-1 border-t border-gray-200">
        <div class="flex items-center px-4">
            <div v-if="$page.props.jetstream?.managesProfilePhotos" class="shrink-0 mr-3">
                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
            </div>

            <div>
                <div class="font-medium text-base text-gray-800">
                    {{ $page.props.user.name }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                    {{ $page.props.user.email }}
                </div>
            </div>
        </div>

        <div class="mt-3 space-y-1">
            <JetResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                Profile
            </JetResponsiveNavLink>

            <JetResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                API Tokens
            </JetResponsiveNavLink>

            <!-- Authentication -->
            <form method="POST" @submit.prevent="logout">
                <JetResponsiveNavLink as="button">
                    Log Out
                </JetResponsiveNavLink>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        hasSidebar: {
            type: Boolean,
            default: false
        }
    },
}
</script>
