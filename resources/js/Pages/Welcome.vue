<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Footer from "@/Components/Footer.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { computed } from "vue";
import PaginationBar from "@/Components/PaginationBar.vue";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    donationRequestsData: Object,
});

const donationRequests = computed(() => {
    return props.donationRequestsData.data;
});
</script>

<template>
    <div>
        <Head title="Welcome" />

        <div class="relative flex min-h-screen bg-white">
            <div>
                <div
                    class="flex w-full justify-between p-2 fixed top-0 bg-gray-900"
                >
                    <ApplicationLogo class="self-start" />

                    <div v-if="canLogin" class="self-center">
                        <Link
                            v-if="$page.props.user"
                            :href="route('dashboard.index')"
                            class="text-sm text-indigo-500 rounded-md outline-none bg-white p-2 hover:bg-indigo-500 hover:text-white"
                            >Dashboard</Link
                        >

                        <template v-else>
                            <div class="hidden sm:block">
                                <Link
                                    :href="route('login')"
                                    class="text-sm text-indigo-500 rounded-md outline-none bg-white p-2 hover:bg-indigo-500 hover:text-white"
                                    >Log in</Link
                                >

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="ml-2 text-sm text-indigo-500 rounded-md outline-none bg-white p-2 hover:bg-indigo-500 hover:text-white"
                                    >Register</Link
                                >
                            </div>

                            <!-- Hamburger -->
                            <div class="relative sm:hidden">
                                <Menu>
                                    <MenuButton>
                                        <button
                                            class="inline-flex items-center justify-center p-2 bg-gray-100 text-gray-500 rounded-md focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
                                        >
                                            <svg
                                                class="h-6 w-6"
                                                stroke="currentColor"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h16"
                                                />
                                            </svg></button
                                    ></MenuButton>
                                    <MenuItems
                                        class="absolute right-0 w-32 rounded-md p-2 mt-3 bg-gray-900"
                                    >
                                        <MenuItem as="div" v-slot="{ active }">
                                            <Link
                                                :href="route('login')"
                                                :class="{
                                                    'text-indigo-500': active,
                                                    'text-white': !active,
                                                }"
                                                class="flex"
                                            >
                                                login
                                            </Link>
                                        </MenuItem>
                                        <MenuItem as="div" v-slot="{ active }">
                                            <Link
                                                :href="route('register')"
                                                :class="{
                                                    'text-indigo-500': active,
                                                    'text-white': !active,
                                                }"
                                                class="flex"
                                            >
                                                register
                                            </Link>
                                        </MenuItem>
                                    </MenuItems>
                                </Menu>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <main class="mt-14 w-full">
                <div
                    style="
                        background-image: url(http://localhost/resources/d8f80683-6d12-49cc-a24f-f44853eaaed4.jpeg);
                        background-repeat: no-repeat;
                        background-position: center center;
                        background-size: cover;
                    "
                    class="p-3 sm:py-8 sm:flex sm:justify-around"
                >
                    <div
                        class="sm:text-center sm:flex sm:items-center sm:justify-center"
                    >
                        <div>
                            <h3 class="text-xl font-semibold">
                                Bring lights to someone who in the dark!
                            </h3>
                            <p class="text-white font-semibold">
                                Donate now and help the community!
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 sm:-mt-0 lg:w-full lg:max-w-sm">
                        <div class="bg-gray-400 p-3 rounded-md">
                            <h3
                                class="text-lg font-semibold text-center pb-3 text-gray-800"
                            >
                                Recent Donator
                            </h3>
                            <div class="divide-y divide-gray-100 space-y-2">
                                <div class="p-1 bg-white rounded-md">
                                    <p>Amirul adli just donated MYR 5.00</p>
                                </div>
                                <div class="p-1 bg-white rounded-md">
                                    <p>Amirul adli just donated MYR 5.00</p>
                                </div>
                                <div class="p-1 bg-white rounded-md">
                                    <p>Amirul adli just donated MYR 5.00</p>
                                </div>
                                <div class="p-1 bg-white rounded-md">
                                    <p>Amirul adli just donated MYR 5.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 w-full flex justify-center md:p-6 lg:p-10">
                    <div class="mx-auto py-8">
                        <h2 class="text-lg font-medium mb-4">
                            Available Donation Requests
                        </h2>
                        <div
                            class="bg-gray-200 rounded-lg shadow-md p-4 md:grid md:grid-cols-3"
                        >
                            <template v-if="donationRequests.length > 0">
                                <template v-for="request in donationRequests" :key="request.id">
                                    <div class="mb-4 md:col-span-1 md:pr-3 lg:pr-5">
                                        <h3 class="text-lg font-medium">
                                            {{ request.title }}
                                            <span
                                                class="text-sm font-light text-indigo-500"
                                                >{{ request.user.name }}</span
                                            >
                                        </h3>
                                        <p class="text-gray-600 mt-1">
                                            {{ request.detail }}
                                        </p>
                                        <div class="mt-3 flex justify-end space-x-3">
                                            <div class="self-end text-xs text-gray-600">
                                                <span class="text-indigo-500">{{ request.progress }}</span>
                                                ({{ request.currently_received }} MYR / {{ request.target_amount }} MYR)
                                            </div>
                                            <button
                                                class="bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600"
                                            >
                                                Donate
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </template>
                            <template v-else>
                                <p class="text-lg font-semibold">No donation requests yet...</p>
                            </template>
                            <PaginationBar :links="donationRequests.links" />
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <Footer />
    </div>
</template>
