<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ChevronUpIcon, XMarkIcon } from "@heroicons/vue/20/solid";
import { ref } from "vue";

const isOpenPaymentAlert = ref(true);
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- visible to every role -->
                <div
                    class="bg-red-600 p-2 sm:p-4 overflow-hidden mb-10 shadow-lg sm:rounded-lg"
                    v-show="isOpenPaymentAlert"
                >
                    <div class="sm:flex sm:justify-between">
                        <div class="flex sm:hidden justify-end mb-2">
                            <XMarkIcon
                                class="text-black h-5 w-5 bg-gray-50 rounded-md cursor-pointer"
                                @click="isOpenPaymentAlert = false"
                            />
                        </div>
                        <p class="text-white text-md font-semibold">
                            For user information, our app only support a payment
                            via online banking. Thank you!.
                        </p>
                        <XMarkIcon
                            class="hidden sm:block self-start text-black h-5 w-5 bg-gray-50 rounded-md cursor-pointer"
                            @click="isOpenPaymentAlert = false"
                        />
                    </div>
                </div>

                <template
                    v-if="
                        !$page.props.inertia.user.roles.includes('needy') &&
                        !$page.props.inertia.user.roles.includes('admin')
                    "
                >
                    <div
                        class="bg-green-400 px-4 py-5 overflow-hidden mb-10 shadow-md sm:rounded-lg"
                    >
                        <h2 class="text-black text-xl">
                            Need financial support? Register now!.
                        </h2>
                        <p class="text-gray-700 text-base mt-2">
                            If you in need of money help, send us your documents
                            and email it at
                            <a
                                href="https://mail.google.com/mail/u/0/#sent?compose=GTvVlcSGKZckjCHVvHTMBjSxpjBFFbFrgpHMMwCgRSqxPJMfPbnCHtCWPZqThmVLsJRSgkqLRCWXt"
                                class="text-indigo-600 underline"
                                >go.sedekah0711@gmail.com</a
                            >
                            for us to validate your documents. After all
                            documents provided is valid, we will give you a
                            permission for asking a donation. But foreach
                            donation request, we will give the authorization
                            whether the request that you are making is make
                            sense or not.
                        </p>
                        <div class="w-full pt-4">
                            <div class="rounded-md bg-white p-2">
                                <Disclosure v-slot="{ open }">
                                    <DisclosureButton
                                        class="flex w-full justify-between rounded-lg bg-indigo-500 p-2 text-left text-sm font-medium text-white hover:bg-indigo-400 focus:outline-none focus-visible:ring focus-visible:ring-indigo-500 focus-visible:ring-opacity-75"
                                    >
                                        <span
                                            >What documents you need to
                                            provide?</span
                                        >
                                        <ChevronUpIcon
                                            :class="
                                                !open
                                                    ? 'rotate-180 transform'
                                                    : ''
                                            "
                                            class="h-5 w-5 text-white"
                                        />
                                    </DisclosureButton>
                                    <DisclosurePanel
                                        class="px-6 pt-4 pb-2 text-sm text-gray-700"
                                    >
                                        <ul class="list-disc space-y-1">
                                            <li>Document 1</li>
                                            <li>Document 2</li>
                                            <li>Document 3</li>
                                            <li>Document 4</li>
                                        </ul>
                                    </DisclosurePanel>
                                </Disclosure>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- visible to every role -->
                <div
                    class="bg-white p-2 sm:p-4 overflow-hidden mb-10 shadow-lg sm:rounded-lg"
                >
                    <h2 class="text-lg">
                        Welcome, {{ $page.props.user.name }}
                    </h2>
                </div>

                <div
                    class="bg-white p-2 sm:p-4 overflow-hidden shadow-lg sm:rounded-lg"
                >
                    <!-- visible to every role -->
                    <div>
                        <h3 class="text-lg text-gray-800 font-semibold mb-2">
                            Personal
                        </h3>
                        <div class="sm:flex">
                            <div class="sm:flex-1">
                                <h3
                                    class="text-md font-semibold text-indigo-500"
                                >
                                    Your donated amount :
                                </h3>
                                <h3 class="text-md">MYR1000.50</h3>
                            </div>
                            <div class="mt-6 sm:-mt-0 sm:last:flex-1">
                                <h3
                                    class="text-md font-semibold text-indigo-500"
                                >
                                    Your last donation :
                                </h3>
                                <h3 class="text-md">
                                    2 December 2022 - 50MYR (shawarna)
                                </h3>
                            </div>
                        </div>
                    </div>

                    <template
                        v-if="$page.props.inertia.user.roles.includes('admin')"
                    >
                        <div class="py-8">
                            <div class="border-t border-gray-200" />
                        </div>

                        <!-- summary -->
                        <div>
                            <h3
                                class="text-lg text-gray-800 font-semibold mb-2"
                            >
                                Donation Summary
                            </h3>
                            <div class="space-y-4">
                                <div class="sm:flex">
                                    <div class="sm:flex-1">
                                        <h3
                                            class="text-md font-semibold text-indigo-500"
                                        >
                                            Accumulated donation :
                                        </h3>
                                        <h3 class="text-md">$50000.50</h3>
                                    </div>
                                    <div class="mt-6 sm:-mt-0 sm:last:flex-1">
                                        <h3
                                            class="text-md font-semibold text-indigo-500"
                                        >
                                            This month accumulated donation :
                                        </h3>
                                        <p class="text-md">$2000</p>
                                    </div>
                                </div>
                                <div class="sm:flex">
                                    <div class="sm:flex-1">
                                        <h3
                                            class="text-md font-semibold text-indigo-500"
                                        >
                                            This month donors :
                                        </h3>
                                        <h3 class="text-md">150</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-8">
                            <div class="border-t border-gray-200" />
                        </div>

                        <!-- recent donation request -->
                        <div>
                            <h3
                                class="text-lg text-gray-800 font-semibold mb-2"
                            >
                                Recent approved donation requests
                            </h3>
                            <div class="relative rounded-md shadow-sm">
                                <div
                                    class="px-4 py-5 bg-indigo-100 rounded-tr-md rounded-tl-md sm:p-6"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div
                                            class="text-md leading-5 font-medium text-gray-900"
                                        >
                                            Abu kamil
                                        </div>
                                    </div>
                                    <div
                                        class="mt-2 sm:flex sm:justify-between"
                                    >
                                        <div class="sm:flex">
                                            <div
                                                class="mr-6 flex items-center text-sm leading-5 text-gray-500"
                                            >
                                                <svg
                                                    class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                                Need support to buy cancer
                                                medecine
                                            </div>
                                        </div>
                                        <div
                                            class="mt-4 sm:mt-0 sm:ml-4 sm:flex-shrink-0 sm:flex sm:justify-end"
                                        >
                                            <dl>
                                                <dt
                                                    class="text-sm text-gray-700"
                                                >
                                                    Current Donation Received
                                                </dt>
                                                <dd
                                                    class="text-sm leading-5 font-medium text-blue-600"
                                                >
                                                    $50
                                                </dd>
                                            </dl>
                                            <dl class="sm:ml-4">
                                                <dt
                                                    class="text-sm text-gray-700"
                                                >
                                                    Donation Goals
                                                </dt>
                                                <dd
                                                    class="text-sm leading-5 font-medium text-green-600"
                                                >
                                                    $100
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div
                                    class="bg-gray-100 rounded-br-md rounded-bl-md px-4 py-4 sm:px-6"
                                >
                                    <div class="text-sm leading-5">
                                        <a
                                            href="#"
                                            class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out"
                                        >
                                            View More
                                        </a>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <div class="py-8">
                            <div class="border-t border-gray-200" />
                        </div>

                        <!-- total users -->
                        <div>
                            <h2
                                class="text-lg font-semibold text-gray-800 mb-2"
                            >
                                Total Users
                            </h2>
                            <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                                <div
                                    class="flex justify-between items-center mb-4"
                                >
                                    <div
                                        class="text-gray-600 font-semibold text-md"
                                    >
                                        Admin
                                    </div>
                                    <div
                                        class="text-gray-800 font-semibold text-md"
                                    >
                                        10
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between items-center mb-4"
                                >
                                    <div
                                        class="text-gray-600 font-semibold text-md"
                                    >
                                        Donor (authenticated)
                                    </div>
                                    <div
                                        class="text-gray-800 font-semibold text-md"
                                    >
                                        20
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between items-center mb-4"
                                >
                                    <div
                                        class="text-gray-600 font-semibold text-md"
                                    >
                                        Needy
                                    </div>
                                    <div
                                        class="text-gray-800 font-semibold text-md"
                                    >
                                        30
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
