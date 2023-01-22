<script setup>
import { onMounted } from "@vue/runtime-core";
import SearchInput from "@/Components/SearchInput.vue";
import DataTable from "@/Components/DataTable.vue";
import PaginationBar from "@/Components/PaginationBar.vue";
import { ref, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import {
    ChevronUpIcon,
    XMarkIcon,
    ChevronDownIcon,
} from "@heroicons/vue/20/solid";
import { CheckCircleIcon, XCircleIcon } from "@heroicons/vue/24/outline";
import { inject } from "vue";

const props = defineProps({
    adminData: Object,
    queryParams: Object,
    queryResult: Object,
});

defineEmits(["searchQuery", "statusQuery"]);

const Swal = inject("$swal");

const searchDonationRequest = ref("");
const searchUserDonationHistory = ref("");

const requests = computed(() => {
    if (
        props.queryParams.role == "admin" &&
        props.queryParams.model == "DonationRequest"
    ) {
        props.queryParams.search
            ? (props.adminData.requestsData.data = props.queryResult)
            : (props.adminData.requestsData = props.queryResult);
    }

    return props.adminData.requestsData;
});

const users = computed(() => {
    if (
        props.queryParams.role == "admin" &&
        props.queryParams.model == "Donation"
    ) {
        props.adminData.usersData.data = props.queryResult;
    }

    return props.adminData.usersData;
});

const approveRequest = (id) => {
    Swal.fire({
        title: "Approve this donation request?",
        text: "Everyone can donate after this.",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "color: rgb(99 102 241);",
        cancelButtonColor: "#d33",
        confirmButtonText: "Approve",
    }).then((result) => {
        if (result.value) {
            Inertia.patch(
                `/donation-request/${id}/approve`,
                {},
                {
                    preserveScroll: false,
                }
            );
        }
    });
};

const rejectRequest = (id) => {
    Swal.fire({
        title: "Reject this request?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "color: rgb(99 102 241);",
        cancelButtonColor: "#d33",
        confirmButtonText: "Reject",
    }).then((result) => {
        if (result.value) {
            Inertia.patch(
                `/donation-request/${id}/reject`,
                {},
                {
                    preserveScroll: false,
                }
            );
        }
    });
};

onMounted(() => {
    if (
        props.queryParams.search &&
        props.queryParams.role == "admin" &&
        props.queryParams.model == "DonationRequest"
    ) {
        searchDonationRequest.value = props.queryParams.search;
    }

    if (
        props.queryParams.search &&
        props.queryParams.role == "admin" &&
        props.queryParams.model == "Donation"
    ) {
        searchUserDonationHistory.value = props.queryParams.search;
    }
});
</script>

<template>
    <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
        <div class="bg-white p-2 sm:p-4 relative shadow-md sm:rounded-lg">
            <h2 class="text-lg font-semibold">User donation requests</h2>
            <div class="sm:flex sm:space-x-1.5">
                <SearchInput
                    :focus-input="
                        props.queryParams.search &&
                        props.queryParams.role == 'admin' &&
                        props.queryParams.model == 'DonationRequest'
                            ? true
                            : false
                    "
                    placeholder="Search needy's name / title"
                    class="sm:w-full"
                    v-model="searchDonationRequest"
                    @input="
                        $emit(
                            'searchQuery',
                            searchDonationRequest,
                            '',
                            'admin',
                            'DonationRequest'
                        )
                    "
                    @click="
                        $emit(
                            'searchQuery',
                            searchDonationRequest,
                            '',
                            'admin',
                            'DonationRequest'
                        )
                    "
                />
                <Menu
                    as="div"
                    class="relative text-left mb-4 sm:self-center sm:-mb-0"
                >
                    <div>
                        <MenuButton
                            class="inline-flex w-full justify-center rounded-md bg-indigo-500 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                        >
                            {{
                                props.queryParams.status
                                    ? props.queryParams.status
                                    : "options"
                            }}
                            <ChevronDownIcon
                                class="ml-2 -mr-1 h-5 w-5 text-violet-200 hover:text-violet-100"
                                aria-hidden="true"
                            />
                        </MenuButton>
                    </div>
                    <transition
                        enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0"
                        enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0"
                    >
                        <MenuItems
                            class="absolute mt-2 z-20 w-full sm:w-26 divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        >
                            <div class="px-1 py-1">
                                <MenuItem v-slot="{ active }">
                                    <button
                                        :class="[
                                            active ? 'bg-gray-200' : '',
                                            'group text-gray-900 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]"
                                        @click="
                                            $emit(
                                                'statusQuery',
                                                '',
                                                '',
                                                'admin',
                                                'DonationRequest'
                                            )
                                        "
                                    >
                                        None
                                    </button>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <button
                                        :class="[
                                            active ? 'bg-gray-200' : '',
                                            props.queryParams.status ==
                                            'approved'
                                                ? 'bg-gray-200'
                                                : '',
                                            'group text-indigo-500 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]"
                                        @click="
                                            $emit(
                                                'statusQuery',
                                                '',
                                                'approved',
                                                'admin',
                                                'DonationRequest'
                                            )
                                        "
                                    >
                                        Approved
                                    </button>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <button
                                        :class="[
                                            active ? 'bg-gray-200' : '',
                                            props.queryParams.status ==
                                            'pending'
                                                ? 'bg-gray-200'
                                                : '',
                                            'group text-orange-500 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]"
                                        @click="
                                            $emit(
                                                'statusQuery',
                                                '',
                                                'pending',
                                                'admin',
                                                'DonationRequest'
                                            )
                                        "
                                    >
                                        Pending
                                    </button>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <button
                                        :class="[
                                            active ? 'bg-gray-200' : '',
                                            props.queryParams.status ==
                                            'rejected'
                                                ? 'bg-gray-200'
                                                : '',
                                            'group text-red-500 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]"
                                        @click="
                                            $emit(
                                                'statusQuery',
                                                '',
                                                'rejected',
                                                'admin',
                                                'DonationRequest'
                                            )
                                        "
                                    >
                                        Rejected
                                    </button>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
            <div class="space-y-4 sm:space-y-6">
                <template v-if="requests.data.length > 0">
                    <template
                        v-for="request in requests.data"
                        :key="request.id"
                    >
                        <template v-if="request.status == 'approved'">
                            <div class="relative rounded-md shadow-sm">
                                <div
                                    class="px-4 py-5 bg-green-100 rounded-tr-md rounded-tl-md sm:p-6"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div
                                            class="text-md font-semibold leading-5 text-indigo-500"
                                        >
                                            {{ request.user.name }}
                                            <span class="text-green-500"
                                                >(Approved)</span
                                            >
                                        </div>
                                    </div>
                                    <div
                                        class="mt-2 flex justify-between leading-5"
                                    >
                                        <h3
                                            class="text-md font-medium text-gray-900 underline"
                                        >
                                            {{ request.title }}
                                        </h3>
                                        <h3 class="text-gray-600 text-sm">
                                            {{ request.created_at }}
                                        </h3>
                                    </div>
                                    <Disclosure v-slot="{ open }">
                                        <DisclosureButton
                                            class="flex mt-2 text-left space-x-1.5 text-sm font-medium text-gray-700"
                                        >
                                            <span>Expand</span>
                                            <ChevronUpIcon
                                                :class="
                                                    !open
                                                        ? 'rotate-180 transform'
                                                        : ''
                                                "
                                                class="h-4 w-4 self-center text-gray-700"
                                            />
                                        </DisclosureButton>
                                        <DisclosurePanel>
                                            <div
                                                class="mt-2 sm:flex sm:justify-between"
                                            >
                                                <div class="sm:flex">
                                                    <div
                                                        class="mr-6 text-sm leading-5 text-gray-500"
                                                    >
                                                        <h4
                                                            class="text-gray-700"
                                                        >
                                                            Detail
                                                        </h4>
                                                        <p>
                                                            {{ request.detail }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="mt-4 sm:mt-0 sm:ml-4 sm:flex-shrink-0 sm:flex sm:justify-end"
                                                >
                                                    <dl>
                                                        <dt
                                                            class="text-sm text-gray-700"
                                                        >
                                                            Current Donation
                                                            Received
                                                        </dt>
                                                        <dd
                                                            class="text-sm leading-5 font-medium text-blue-600"
                                                        >
                                                            {{
                                                                request.currently_received
                                                            }}
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
                                                            {{
                                                                request.target_amount
                                                            }}
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </DisclosurePanel>
                                    </Disclosure>
                                </div>
                                <div
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
                                </div>
                            </div></template
                        >
                        <template v-if="request.status == 'pending'">
                            <div class="relative rounded-md shadow-sm">
                                <div
                                    class="px-4 py-5 bg-orange-100 rounded-tr-md rounded-tl-md sm:p-6"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div
                                            class="text-md font-semibold leading-5 text-indigo-500"
                                        >
                                            {{ request.user.name }}
                                            <span class="text-orange-500"
                                                >(Pending)</span
                                            >
                                        </div>
                                    </div>
                                    <div
                                        class="mt-2 flex justify-between leading-5"
                                    >
                                        <h3
                                            class="text-md font-medium text-gray-900 underline"
                                        >
                                            {{ request.title }}
                                        </h3>
                                        <h3 class="text-gray-600 text-sm">
                                            {{ request.created_at }}
                                        </h3>
                                    </div>
                                    <Disclosure v-slot="{ open }">
                                        <DisclosureButton
                                            class="flex mt-2 text-left space-x-1.5 text-sm font-medium text-gray-700"
                                        >
                                            <span>Expand</span>
                                            <ChevronUpIcon
                                                :class="
                                                    !open
                                                        ? 'rotate-180 transform'
                                                        : ''
                                                "
                                                class="h-4 w-4 self-center text-gray-700"
                                            />
                                        </DisclosureButton>
                                        <DisclosurePanel>
                                            <div
                                                class="mt-2 sm:flex sm:justify-between"
                                            >
                                                <div class="sm:flex">
                                                    <div
                                                        class="mr-6 text-sm leading-5 text-gray-500"
                                                    >
                                                        <h4
                                                            class="text-gray-700"
                                                        >
                                                            Detail
                                                        </h4>
                                                        <p>
                                                            {{ request.detail }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="mt-4 sm:mt-0 sm:ml-4 sm:flex-shrink-0 sm:flex sm:justify-end"
                                                >
                                                    <dl>
                                                        <dt
                                                            class="text-sm text-gray-700"
                                                        >
                                                            Donation Goals
                                                        </dt>
                                                        <dd
                                                            class="text-sm leading-5 font-medium text-green-600"
                                                        >
                                                            {{
                                                                request.target_amount
                                                            }}
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </DisclosurePanel>
                                    </Disclosure>
                                </div>
                                <div
                                    class="bg-gray-100 rounded-br-md rounded-bl-md px-4 py-4 sm:px-6"
                                >
                                    <div
                                        class="flex space-x-3 text-sm leading-5"
                                    >
                                        <button
                                            class="text-green-500 inline-flex"
                                            @click="approveRequest(request.id)"
                                        >
                                            Approve
                                            <CheckCircleIcon
                                                class="h-4 w-4 ml-1.5 self-center"
                                            />
                                        </button>
                                        <button
                                            class="text-red-500 inline-flex"
                                            @click="rejectRequest(request.id)"
                                        >
                                            Reject
                                            <XCircleIcon
                                                class="h-4 w-4 ml-1.5 self-center"
                                            />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-if="request.status == 'rejected'">
                            <div class="relative rounded-md shadow-sm">
                                <div
                                    class="px-4 py-5 bg-red-100 rounded-tr-md rounded-tl-md sm:p-6"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div
                                            class="text-md font-semibold leading-5 text-indigo-500"
                                        >
                                            {{ request.user.name }}
                                            <span class="text-red-500"
                                                >(Rejected)</span
                                            >
                                        </div>
                                    </div>
                                    <div
                                        class="mt-2 flex justify-between leading-5"
                                    >
                                        <h3
                                            class="text-md font-medium text-gray-900 underline"
                                        >
                                            {{ request.title }}
                                        </h3>
                                        <h3 class="text-gray-600 text-sm">
                                            {{ request.created_at }}
                                        </h3>
                                    </div>
                                    <Disclosure v-slot="{ open }">
                                        <DisclosureButton
                                            class="flex mt-2 text-left space-x-1.5 text-sm font-medium text-gray-700"
                                        >
                                            <span>Expand</span>
                                            <ChevronUpIcon
                                                :class="
                                                    !open
                                                        ? 'rotate-180 transform'
                                                        : ''
                                                "
                                                class="h-4 w-4 self-center text-gray-700"
                                            />
                                        </DisclosureButton>
                                        <DisclosurePanel>
                                            <div
                                                class="mt-2 sm:flex sm:justify-between"
                                            >
                                                <div class="sm:flex">
                                                    <div
                                                        class="mr-6 text-sm leading-5 text-gray-500"
                                                    >
                                                        <h4
                                                            class="text-gray-700"
                                                        >
                                                            Detail
                                                        </h4>
                                                        <p>
                                                            {{ request.detail }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </DisclosurePanel>
                                    </Disclosure>
                                </div>
                            </div>
                        </template>
                    </template>
                </template>
                <template v-else>
                    <h3 class="text-md mt-2">No result</h3>
                </template>
            </div>
            <PaginationBar :links="requests.links" />
        </div>
    </div>

    <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
        <div class="bg-white p-2 sm:p-4 relative shadow-md sm:rounded-lg">
            <h2 class="text-lg font-semibold">User donation histories</h2>
            <SearchInput
                :focus-input="
                    props.queryParams.search &&
                    props.queryParams.role == 'admin' &&
                    props.queryParams.model == 'Donation'
                        ? true
                        : false
                "
                placeholder="Search donator / receiver / title"
                v-model="searchUserDonationHistory"
                @input="
                    $emit(
                        'searchQuery',
                        searchUserDonationHistory,
                        '',
                        'admin',
                        'Donation'
                    )
                "
                @click="
                    $emit(
                        'searchQuery',
                        searchUserDonationHistory,
                        '',
                        'admin',
                        'Donation'
                    )
                "
            />
            <DataTable
                :header-data="[
                    '#',
                    'Donator',
                    'Receiver',
                    'Title',
                    'Amount',
                    'Date',
                ]"
                :body-data="users.data"
                type="user-histories"
            />
            <PaginationBar :links="users.links" />
        </div>
    </div>
</template>
