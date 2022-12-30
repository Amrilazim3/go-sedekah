<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Footer from "@/Components/Footer.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import ApplicationMark from '@/Components/ApplicationMark.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <div>
        <Head title="Welcome" />

        <div
            class="relative flex items-top justify-center min-h-screen bg-white"
        >
            <div
                v-if="canLogin"
                class="fixed top-0 right-0 px-6 py-4"
            >
                <Link
                    v-if="$page.props.user"
                    :href="route('dashboard')"
                    class="text-sm text-gray-700 dark:text-gray-500 underline"
                    >Dashboard</Link
                >

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="text-sm text-gray-700 dark:text-gray-500 underline"
                        >Log in</Link
                    >

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"
                        >Register</Link
                    >
                </template>
            </div>

            <main>
                <p>Go-Sedekah. What you do today will affect others life to better.</p>
            </main>
        </div>

        <Footer />
    </div>
</template>
