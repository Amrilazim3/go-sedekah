<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ChevronUpIcon, XMarkIcon } from "@heroicons/vue/20/solid";
import { ref } from "vue";
import Needy from "@/Components/DashboardByRoles/Needy.vue";
import Admin from "@/Components/DashboardByRoles/Admin.vue";
import Donor from "@/Components/DashboardByRoles/Donor.vue";

const props = defineProps({
    dataRoles: Object,
});

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

                <!-- visible to donor -->
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

                <!-- main content -->
                <div
                    class="bg-white p-2 sm:p-4 overflow-hidden shadow-lg sm:rounded-lg"
                >
                    <!-- donor content -->
                    <template v-if="$page.props.inertia.user.roles.includes('donor')">
                        <Donor :data="props.dataRoles['donor']" />
                    </template>

                    <!-- admin content -->
                    <template
                        v-if="$page.props.inertia.user.roles.includes('admin')"
                    >
                        <Admin :data="props.dataRoles['admin']" />
                    </template>

                    <!-- needy content -->
                    <template
                        v-if="$page.props.inertia.user.roles.includes('needy')"
                    >
                        <Needy :data="props.dataRoles['needy']" />
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
