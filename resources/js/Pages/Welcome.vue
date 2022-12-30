<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Footer from "@/Components/Footer.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
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
                            :href="route('dashboard')"
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

            <main class="mt-16 p-4 w-full flex justify-center">
                <div>
                    <div class="sm:text-center">
                        <h3 class="text-xl font-semibold">
                            Bring lights to someone who in the dark!
                        </h3>
                        <p class="text-gray-600">
                            Donate now and help the community!
                        </p>
                    </div>

                    <div class="mt-8 bg-blue-200 p-3 rounded-md">
                        <h3 class="text-lg text-center pb-3 text-indigo-600">
                            Donate available
                        </h3>
                        <div class="divide-y divide-gray-100 space-y-4">
                            <div>
                                <div class="flex w-full">
                                    <button
                                        class="bg-white p-1.5 flex-1 outline-none rounded-tl-md text-md"
                                    >
                                        Siti kaliz
                                    </button>
                                    <button
                                        class="bg-gray-900 p-1.5 flex-1 outline-none rounded-tr-md text-white text-md"
                                    >
                                        <span class="text-red-500">MYR500</span>
                                        /
                                        <span class="text-green-500"
                                            >MYR20000</span
                                        >
                                    </button>
                                </div>
                                <button
                                    class="w-full p-1.5 font-semibold bg-indigo-500 hover:bg-indigo-400 rounded-br-md rounded-bl-md text-white"
                                >
                                    Donate
                                </button>
                            </div>
                            <div>
                                <div class="flex w-full">
                                    <button
                                        class="bg-white p-1.5 flex-1 outline-none rounded-tl-md text-md"
                                    >
                                        Emsan hanief
                                    </button>
                                    <button
                                        class="bg-gray-900 p-1.5 flex-1 outline-none rounded-tr-md text-white text-md"
                                    >
                                        <span class="text-red-500">MYR500</span>
                                        /
                                        <span class="text-green-500"
                                            >MYR20000</span
                                        >
                                    </button>
                                </div>
                                <button
                                    class="w-full p-1.5 font-semibold bg-indigo-500 hover:bg-indigo-400 rounded-br-md rounded-bl-md text-white"
                                >
                                    Donate
                                </button>
                            </div>
                            <div>
                                <div class="flex w-full">
                                    <button
                                        class="bg-white p-1.5 flex-1 outline-none rounded-tl-md text-md"
                                    >
                                        Ammar asri
                                    </button>
                                    <button
                                        class="bg-gray-900 p-1.5 flex-1 outline-none rounded-tr-md text-white text-md"
                                    >
                                        <span class="text-red-500">MYR500</span>
                                        /
                                        <span class="text-green-500"
                                            >MYR20000</span
                                        >
                                    </button>
                                </div>
                                <button
                                    class="w-full p-1.5 font-semibold bg-indigo-500 hover:bg-indigo-400 rounded-br-md rounded-bl-md text-white"
                                >
                                    Donate
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 bg-indigo-200 p-3 rounded-md">
                        <h3 class="text-lg text-center pb-3 text-blue-500">
                            Recent Donator
                        </h3>
                        <div class="divide-y divide-gray-100 space-y-2">
                            <div class="p-1 bg-white">
                                <p>Amirul adli just donated MYR 5.00</p>
                            </div>
                            <div class="p-1 bg-white">
                                <p>Mira filzah just donated MYR 5.00</p>
                            </div>
                            <div class="p-1 bg-white">
                                <p>abu zaki just donated MYR 5.00</p>
                            </div>
                            <div class="p-1 bg-white">
                                <p>Kamal adli just donated MYR 5.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <Footer />
    </div>
</template>
