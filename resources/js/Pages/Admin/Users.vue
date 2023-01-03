<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { onMounted, reactive } from "vue";

const props = defineProps({
    usersData: Object,
});

const admins = reactive(props.usersData.admins);
const donors = reactive(props.usersData.donors.data);
const needy = reactive(props.usersData.needy.data);
</script>

<template>
    <AppLayout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <!-- admin users -->
            <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-2 overflow-hidden shadow-md sm:rounded-lg"
                >
                    <h2 class="text-lg font-semibold">Admins</h2>
                    <div class="relative rounded-md py-2 sm:py-4">
                        <input
                            type="search"
                            class="form-input py-2 pl-10 block w-full leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:border-indigo-300 focus:shadow-outline-blue sm:text-sm sm:leading-5"
                            placeholder="Search admin"
                        />
                        <div
                            class="absolute top-0 left-0 flex items-center h-full px-4 pointer-events-none"
                        >
                            <svg
                                class="h-5 w-5 text-gray-400"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </div>
                    </div>
                    <table class="w-full text-left table-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="text-sm font-semibold text-gray-700 p-4 bg-gray-100"
                                >
                                    Name
                                </th>
                                <th
                                    class="text-sm font-semibold text-gray-700 p-4 bg-gray-100"
                                >
                                    Email
                                </th>
                                <th
                                    class="text-sm font-semibold text-gray-700 p-4 bg-gray-100"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <template v-if="admins.length > 0">
                            <tbody>
                                <template
                                    v-for="admin in admins"
                                    :key="admin.id"
                                >
                                    <tr>
                                        <td
                                            class="p-4 border-t border-gray-200"
                                        >
                                            {{ admin.name }}
                                        </td>
                                        <td
                                            class="p-4 border-t border-gray-200"
                                        >
                                            {{ admin.email }}
                                        </td>
                                        <td
                                            class="p-4 border-t border-gray-200"
                                        >
                                            <a
                                                href="#"
                                                class="text-xs font-semibold text-indigo-600 hover:text-indigo-800"
                                                >Edit</a
                                            >
                                            <a
                                                href="#"
                                                class="text-xs font-semibold text-red-600 hover:text-red-800 ml-4"
                                                >Delete</a
                                            >
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </template>
                        <template v-else>
                            <h3 class="text-md font-semibold text-gray-600 p-2">
                                No data
                            </h3>
                        </template>
                    </table>
                </div>
            </div>

            <!-- donor users -->
            <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-2 overflow-x-scroll shadow-md sm:rounded-lg"
                >
                    <h2 class="text-lg font-semibold">Donors</h2>
                    <div class="relative rounded-md py-2 sm:py-4">
                        <input
                            type="search"
                            class="form-input py-2 pl-10 block w-full leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:border-indigo-300 focus:shadow-outline-blue sm:text-sm sm:leading-5"
                            placeholder="Search donor"
                        />
                        <div
                            class="absolute top-0 left-0 flex items-center h-full px-4 pointer-events-none"
                        >
                            <svg
                                class="h-5 w-5 text-gray-400"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </div>
                    </div>
                    <table class="w-full text-left table-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="text-sm font-semibold text-gray-700 p-4 bg-gray-100"
                                >
                                    Name
                                </th>
                                <th
                                    class="text-sm font-semibold text-gray-700 p-4 bg-gray-100"
                                >
                                    Email
                                </th>
                                <th
                                    class="text-sm font-semibold text-gray-700 p-4 bg-gray-100"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <template v-if="donors.length > 0">
                            <tbody>
                                <template
                                    v-for="donor in donors"
                                    :key="donor.id"
                                >
                                    <tr>
                                        <td
                                            class="p-4 border-t border-gray-200"
                                        >
                                            {{ donor.name }}
                                        </td>
                                        <td
                                            class="p-4 border-t border-gray-200"
                                        >
                                            {{ donor.email }}
                                        </td>
                                        <td
                                            class="p-4 border-t border-gray-200"
                                        >
                                            <a
                                                href="#"
                                                class="text-xs font-semibold text-indigo-600 hover:text-indigo-800"
                                                >Edit</a
                                            >
                                            <a
                                                href="#"
                                                class="text-xs font-semibold text-red-600 hover:text-red-800 ml-4"
                                                >Delete</a
                                            >
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </template>
                        <template v-else>
                            <h3 class="text-md font-semibold text-gray-600 p-2">
                                No data
                            </h3>
                        </template>
                    </table>
                </div>
            </div>

            <!-- needy users -->
            <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-2 overflow-hidden shadow-md sm:rounded-lg"
                >
                    <h2 class="text-lg font-semibold">Needy</h2>
                    <div class="relative rounded-md py-2 sm:py-4">
                        <input
                            type="search"
                            class="form-input py-2 pl-10 block w-full leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:border-indigo-300 focus:shadow-outline-blue sm:text-sm sm:leading-5"
                            placeholder="Search needy"
                        />
                        <div
                            class="absolute top-0 left-0 flex items-center h-full px-4 pointer-events-none"
                        >
                            <svg
                                class="h-5 w-5 text-gray-400"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </div>
                    </div>
                    <table class="w-full text-left table-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="text-sm font-semibold text-gray-700 p-4 bg-gray-100"
                                >
                                    Name
                                </th>
                                <th
                                    class="text-sm font-semibold text-gray-700 p-4 bg-gray-100"
                                >
                                    Email
                                </th>
                                <th
                                    class="text-sm font-semibold text-gray-700 p-4 bg-gray-100"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="needy.length > 0">
                                <template v-for="needyS in needy" :key="needyS">
                                    <tr>
                                        <td
                                            class="p-4 border-t border-gray-200"
                                        >
                                            {{ needyS.name }}
                                        </td>
                                        <td
                                            class="p-4 border-t border-gray-200"
                                        >
                                            {{ needyS.email }}
                                        </td>
                                        <td
                                            class="p-4 border-t border-gray-200"
                                        >
                                            <a
                                                href="#"
                                                class="text-xs font-semibold text-indigo-600 hover:text-indigo-800"
                                                >Edit</a
                                            >
                                            <a
                                                href="#"
                                                class="text-xs font-semibold text-red-600 hover:text-red-800 ml-4"
                                                >Delete</a
                                            >
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <template v-else>
                                <h3
                                    class="text-md font-semibold text-gray-600 p-2"
                                >
                                    No data
                                </h3>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
