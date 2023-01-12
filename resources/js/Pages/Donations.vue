<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ChevronUpIcon, XMarkIcon } from "@heroicons/vue/20/solid";
</script>

<template>
    <AppLayout title="Donations">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Donations
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- visible to every role -->
                <div
                    class="bg-white p-2 sm:p-4 overflow-hidden mb-10 shadow-lg sm:rounded-lg"
                >
                    <h2 class="text-lg">
                        Show donations content by user's role
                    </h2>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
