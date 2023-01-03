<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ChevronUpIcon } from "@heroicons/vue/20/solid";
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
                <template v-if="$page.props.inertia.user.roles[0] == 'donor'">
                    <div
                        class="bg-green-300 px-4 py-5 overflow-hidden mb-10 shadow-md sm:rounded-lg"
                    >
                        <h2 class="text-black text-xl">
                            Need financial support? register now!
                        </h2>
                        <p class="text-gray-700 text-base mt-2">
                            If you in need of money help, send us your documents
                            and email it at
                            <a
                                href="https://mail.google.com/mail/u/0/#sent?compose=GTvVlcSGKZckjCHVvHTMBjSxpjBFFbFrgpHMMwCgRSqxPJMfPbnCHtCWPZqThmVLsJRSgkqLRCWXt"
                                class="text-indigo-500 underline"
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
                                        <span>What documents you need to provide?</span>
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

                <div
                    class="bg-white p-2 overflow-hidden shadow-xl sm:rounded-lg"
                >
                    <h2>Hye, {{ $page.props.inertia.user.roles[0] }}</h2>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
