<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import SearchInput from "@/Components/SearchInput.vue";
import { Inertia } from "@inertiajs/inertia";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import PaginationBar from "@/Components/PaginationBar.vue";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import {
    ChevronUpIcon,
    XMarkIcon,
    ChevronDownIcon,
} from "@heroicons/vue/20/solid";
import { CheckCircleIcon, XCircleIcon } from "@heroicons/vue/24/outline";
import { computed, ref, inject, reactive, onMounted } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { debounce } from "lodash";

const props = defineProps({
    bankAccounts: Array,
    historiesData: Object,
    requestsData: Object || Array,
    usersData: Object || Array,
    querySearchResult: Object || Array,
    queryParams: Object,
});

const histories = computed(() => {
    if (props.queryParams.type == "histories" && props.queryParams.search) {
        props.historiesData.data = props.querySearchResult;
    }

    return props.historiesData;
});

const requests = computed(() => {
    if (
        (props.queryParams.type == "admin-requests" || props.queryParams.type == "needy-requests") &&
        (props.queryParams.search || props.queryParams.status)
    ) {
        props.requestsData.data = props.querySearchResult;
    }

    return props.requestsData;
});

const users = computed(() => {
    if (props.queryParams.type == "users" && props.queryParams.search) {
        props.usersData.data = props.querySearchResult;
    }

    return props.usersData;
});

const hasBankAccounts = computed(() => {
    if (props.bankAccounts.length > 0) {
        return true;
    }

    return false;
});

const Swal = inject("$swal");

const searchDonationHistory = ref("");

const searchDonationRequest = ref("");

const searchUserDonationHistory = ref("");

const isOpenDonationRequestModal = ref(false);

const statusParams = reactive({
    status: props.queryParams.status,
    type: props.queryParams.type,
});

const searchParams = reactive({
    search: props.queryParams.search,
    type: props.queryParams.type,
});

const donationRequestForm = useForm({
    title: "",
    detail: "",
    targetAmount: null,
    bankAccountId: null,
});

onMounted(() => {
    if (props.queryParams.type == "histories") {
        searchDonationHistory.value = props.queryParams.search;
    }

    if (
        props.queryParams.type == "admin-requests" ||
        props.queryParams.type == "needy-requests"
    ) {
        searchDonationRequest.value = props.queryParams.search;
    }

    if (props.queryParams.type == "users") {
        searchUserDonationHistory.value = props.queryParams.search;
    }
});

const submit = () => {
    donationRequestForm
        .transform((data) => ({
            ...data,
        }))
        .post(route("donations.store"), {
            preserveScroll: false,
            onSuccess: () => {
                isOpenDonationRequestModal.value = false;
                donationRequestForm.reset();
            },
        });
};

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
                `/donations/${id}/approve`,
                {},
                {
                    preserveScroll: true,
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
                `/donations/${id}/reject`,
                {},
                {
                    preserveScroll: true,
                }
            );
        }
    });
};

const deleteDonationRequest = (id) => {
    Swal.fire({
        title: "Delete this request?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "color: rgb(99 102 241);",
        cancelButtonColor: "#d33",
        confirmButtonText: "Delete",
    }).then((result) => {
        if (result.value) {
            Inertia.delete(`/donations/${id}`, {
                preserveScroll: true,
            });
        }
    });
};

const search = debounce((search, type) => {
    if (!searchParams.search && !search) {
        return;
    }

    searchParams.search = search;
    searchParams.type = type;

    Inertia.get("/donations", searchParams, {
        preserveScroll: true,
    });
}, 500);

const sortDonationRequestStatus = debounce((status, type) => {
    if (status == "none") {
        console.log("none selected");
        return;
    }

    statusParams.status = status;
    statusParams.type = type;

    Inertia.get("/donations", statusParams, {
        preserveScroll: true,
    });
}, 500);
</script>

<template>
    <AppLayout title="Donations">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Donations
            </h2>
        </template>

        <div class="py-12">
            <!-- visible to every role -->
            <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-2 sm:p-4 relative shadow-md sm:rounded-lg"
                >
                    <h2 class="text-lg font-semibold">
                        Your donation histories
                    </h2>
                    <SearchInput
                        :focus-input="
                            props.queryParams.type == 'histories' ? true : false
                        "
                        placeholder="Search receiver / title"
                        v-model="searchDonationHistory"
                        @input="search(searchDonationHistory, 'histories')"
                        @click="search(searchDonationHistory, 'histories')"
                    />
                    <DataTable
                        :header-data="[
                            '#',
                            'Receiver',
                            'Title',
                            'Amount',
                            'Date',
                            'Receipt',
                        ]"
                        :body-data="histories.data"
                        type="histories"
                    />
                </div>
            </div>

            <!-- show user donation requests (admin) -->
            <template v-if="$page.props.inertia.user.roles.includes('admin')">
                <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
                    <div
                        class="bg-white p-2 sm:p-4 relative shadow-md sm:rounded-lg"
                    >
                        <h2 class="text-lg font-semibold">
                            User donation requests
                        </h2>
                        <div class="sm:flex sm:space-x-1.5">
                            <SearchInput
                                :focus-input="
                                    props.queryParams.type == 'admin-requests'
                                        ? true
                                        : false
                                "
                                placeholder="Search needy's name / title"
                                class="sm:w-full"
                                v-model="searchDonationRequest"
                                @input="
                                    search(
                                        searchDonationRequest,
                                        'admin-requests'
                                    )
                                "
                                @click="
                                    search(
                                        searchDonationRequest,
                                        'admin-requests'
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
                                        Options
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
                                                        active
                                                            ? 'bg-gray-200'
                                                            : '',
                                                        'group text-gray-900 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                    ]"
                                                    @click="
                                                        sortDonationRequestStatus(
                                                            'none',
                                                            'admin-requests'
                                                        )
                                                    "
                                                >
                                                    None
                                                </button>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }">
                                                <button
                                                    :class="[
                                                        active
                                                            ? 'bg-gray-200'
                                                            : '',
                                                        'group text-indigo-500 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                    ]"
                                                    @click="
                                                        sortDonationRequestStatus(
                                                            'approved',
                                                            'admin-requests'
                                                        )
                                                    "
                                                >
                                                    Approved
                                                </button>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }">
                                                <button
                                                    :class="[
                                                        active
                                                            ? 'bg-gray-200'
                                                            : '',
                                                        'group text-orange-500 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                    ]"
                                                    @click="
                                                        sortDonationRequestStatus(
                                                            'pending',
                                                            'admin-requests'
                                                        )
                                                    "
                                                >
                                                    Pending
                                                </button>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }">
                                                <button
                                                    :class="[
                                                        active
                                                            ? 'bg-gray-200'
                                                            : '',
                                                        'group text-red-500 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                    ]"
                                                    @click="
                                                        sortDonationRequestStatus(
                                                            'rejected',
                                                            'admin-requests'
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
                                    <template
                                        v-if="request.status == 'approved'"
                                    >
                                        <div
                                            class="relative rounded-md shadow-sm"
                                        >
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
                                                        <span
                                                            class="text-green-500"
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
                                                    <h3
                                                        class="text-gray-600 text-sm"
                                                    >
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
                                                            <div
                                                                class="sm:flex"
                                                            >
                                                                <div
                                                                    class="mr-6 text-sm leading-5 text-gray-500"
                                                                >
                                                                    <h4
                                                                        class="text-gray-700"
                                                                    >
                                                                        Detail
                                                                    </h4>
                                                                    <p>
                                                                        {{
                                                                            request.detail
                                                                        }}
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
                                                                        Current
                                                                        Donation
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
                                                                <dl
                                                                    class="sm:ml-4"
                                                                >
                                                                    <dt
                                                                        class="text-sm text-gray-700"
                                                                    >
                                                                        Donation
                                                                        Goals
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
                                    <template
                                        v-if="request.status == 'pending'"
                                    >
                                        <div
                                            class="relative rounded-md shadow-sm"
                                        >
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
                                                        <span
                                                            class="text-orange-500"
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
                                                    <h3
                                                        class="text-gray-600 text-sm"
                                                    >
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
                                                            <div
                                                                class="sm:flex"
                                                            >
                                                                <div
                                                                    class="mr-6 text-sm leading-5 text-gray-500"
                                                                >
                                                                    <h4
                                                                        class="text-gray-700"
                                                                    >
                                                                        Detail
                                                                    </h4>
                                                                    <p>
                                                                        {{
                                                                            request.detail
                                                                        }}
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
                                                                        Donation
                                                                        Goals
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
                                                        @click="
                                                            approveRequest(
                                                                request.id
                                                            )
                                                        "
                                                    >
                                                        Approve
                                                        <CheckCircleIcon
                                                            class="h-4 w-4 ml-1.5 self-center"
                                                        />
                                                    </button>
                                                    <button
                                                        class="text-red-500 inline-flex"
                                                        @click="
                                                            rejectRequest(
                                                                request.id
                                                            )
                                                        "
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
                                    <template
                                        v-if="request.status == 'rejected'"
                                    >
                                        <div
                                            class="relative rounded-md shadow-sm"
                                        >
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
                                                        <span
                                                            class="text-red-500"
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
                                                    <h3
                                                        class="text-gray-600 text-sm"
                                                    >
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
                                                            <div
                                                                class="sm:flex"
                                                            >
                                                                <div
                                                                    class="mr-6 text-sm leading-5 text-gray-500"
                                                                >
                                                                    <h4
                                                                        class="text-gray-700"
                                                                    >
                                                                        Detail
                                                                    </h4>
                                                                    <p>
                                                                        {{
                                                                            request.detail
                                                                        }}
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
            </template>

            <!-- show user donation histories (admin) -->
            <template v-if="$page.props.inertia.user.roles.includes('admin')">
                <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
                    <div
                        class="bg-white p-2 sm:p-4 relative shadow-md sm:rounded-lg"
                    >
                        <h2 class="text-lg font-semibold">
                            User donation histories
                        </h2>
                        <SearchInput
                            :focus-input="
                                props.queryParams.type == 'users' ? true : false
                            "
                            placeholder="Search donator / receiver / title"
                            v-model="searchUserDonationHistory"
                            @input="search(searchUserDonationHistory, 'users')"
                            @click="search(searchUserDonationHistory, 'users')"
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

            <!-- show donation requests (needy) -->
            <template v-if="$page.props.inertia.user.roles.includes('needy')">
                <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
                    <div
                        class="bg-white p-2 sm:p-4 relative shadow-md sm:rounded-lg"
                    >
                        <div
                            class="text-lg sm:flex sm:justify-between font-semibold"
                        >
                            <h2 class="text-lg font-semibold">
                                Your donation requests
                            </h2>
                            <div class="sm:inline-flex">
                                <p
                                    class="text-sm text-red-500 self-start mr-2"
                                    :class="hasBankAccounts ? 'hidden' : ''"
                                >
                                    must have at least one bank account setup.
                                </p>
                                <button
                                    class="w-full sm:w-fit text-sm font-semibold px-3 py-1.5 mt-2 mb-2 sm:mt-0 text-white rounded-md"
                                    :class="
                                        hasBankAccounts
                                            ? 'bg-indigo-500 hover:bg-opacity-50'
                                            : 'bg-indigo-300 cursor-not-allowed'
                                    "
                                    @click="isOpenDonationRequestModal = true"
                                    :disabled="!hasBankAccounts"
                                >
                                    make new request
                                </button>
                            </div>
                        </div>
                        <div class="sm:flex sm:space-x-1.5">
                            <SearchInput
                                :focus-input="
                                    props.queryParams.type == 'needy-requests'
                                        ? true
                                        : false
                                "
                                placeholder="search donation title"
                                class="sm:w-full"
                                v-model="searchDonationRequest"
                                @input="
                                    search(
                                        searchDonationRequest,
                                        'needy-requests'
                                    )
                                "
                                @click="
                                    search(
                                        searchDonationRequest,
                                        'needy-requests'
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
                                        Options
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
                                                        active
                                                            ? 'bg-gray-200'
                                                            : '',
                                                        'group text-gray-900 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                    ]"
                                                    @click="
                                                        sortDonationRequestStatus(
                                                            'none',
                                                            'needy-requests'
                                                        )
                                                    "
                                                >
                                                    None
                                                </button>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }">
                                                <button
                                                    :class="[
                                                        active
                                                            ? 'bg-gray-200'
                                                            : '',
                                                        'group text-indigo-500 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                    ]"
                                                    @click="
                                                        sortDonationRequestStatus(
                                                            'approved',
                                                            'needy-requests'
                                                        )
                                                    "
                                                >
                                                    Approved
                                                </button>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }">
                                                <button
                                                    :class="[
                                                        active
                                                            ? 'bg-gray-200'
                                                            : '',
                                                        'group text-orange-500 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                    ]"
                                                    @click="
                                                        sortDonationRequestStatus(
                                                            'pending',
                                                            'needy-requests'
                                                        )
                                                    "
                                                >
                                                    Pending
                                                </button>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }">
                                                <button
                                                    :class="[
                                                        active
                                                            ? 'bg-gray-200'
                                                            : '',
                                                        'group text-red-500 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                    ]"
                                                    @click="
                                                        sortDonationRequestStatus(
                                                            'rejected',
                                                            'needy-requests'
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
                        <DataTable
                            :header-data="[
                                '#',
                                'Title',
                                'Progress',
                                'Status',
                                'Requested Date',
                                'Verified',
                                'Verification Expiry Date',
                                'Actions',
                            ]"
                            :body-data="requests.data"
                            type="needy-requests"
                            @deleteDonationRequest="deleteDonationRequest"
                        />
                        <PaginationBar :links="requests.links" />
                    </div>
                </div>
            </template>
        </div>

        <!-- new donation request form -->
        <TransitionRoot appear :show="isOpenDonationRequestModal" as="template">
            <Dialog
                as="div"
                @close="isOpenDonationRequestModal = true"
                class="relative z-10"
            >
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black bg-opacity-25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center p-4 text-center"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                            >
                                <form @submit.prevent="submit">
                                    <DialogTitle
                                        as="h3"
                                        class="text-lg font-medium leading-6 text-gray-900"
                                    >
                                        Make Donation Request
                                    </DialogTitle>
                                    <div class="mt-4">
                                        <InputLabel for="title" value="Title" />
                                        <TextInput
                                            id="title"
                                            v-model="donationRequestForm.title"
                                            type="text"
                                            class="mt-1 block w-full"
                                            required
                                            autofocus
                                            placeholder="Donation title"
                                        />
                                        <InputError
                                            class="mt-2"
                                            :message="
                                                donationRequestForm.errors.title
                                            "
                                        />
                                    </div>
                                    <div class="mt-4">
                                        <InputLabel
                                            for="detail"
                                            value="Detail"
                                        />
                                        <TextAreaInput
                                            id="detail"
                                            v-model="donationRequestForm.detail"
                                            class="mt-1 block w-full"
                                            required
                                            placeholder="Describe your reason to support title"
                                        />
                                        <InputError
                                            class="mt-2"
                                            :message="
                                                donationRequestForm.errors
                                                    .detail
                                            "
                                        />
                                    </div>
                                    <div class="mt-4">
                                        <InputLabel
                                            for="target-amount"
                                            value="Target donation amount"
                                        />
                                        <TextInput
                                            id="target-amount"
                                            v-model="
                                                donationRequestForm.targetAmount
                                            "
                                            type="number"
                                            class="mt-1 block w-full"
                                            required
                                            placeholder="500"
                                        />
                                        <InputError
                                            class="mt-2"
                                            :message="
                                                donationRequestForm.errors
                                                    .targetAmount
                                            "
                                        />
                                    </div>
                                    <div class="mt-4">
                                        <InputLabel
                                            for="bank-acc"
                                            value="Bank account"
                                        />
                                        <SelectInput
                                            id="bank-acc"
                                            v-model="
                                                donationRequestForm.bankAccountId
                                            "
                                            :data="bankAccounts"
                                            class="mt-1 block w-full"
                                            required
                                        />
                                        <InputError
                                            class="mt-2"
                                            :message="
                                                donationRequestForm.errors
                                                    .bankAccountId
                                            "
                                        />
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600">
                                            You must wait for an admin to
                                            approve your request after making
                                            this request.
                                        </p>
                                        <p class="text-sm mt-2 text-gray-600">
                                            You can delete your donation request
                                            while it is in pending state, after
                                            the request is approved, it can't be
                                            deleted.
                                        </p>
                                    </div>
                                    <div
                                        class="flex justify-end space-x-1.5 mt-4"
                                    >
                                        <button
                                            type="button"
                                            class="inline-flex justify-center rounded-md border border-transparent bg-red-500 px-4 py-2 text-sm font-medium text-gray-800 hover:bg-red-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2"
                                            @click="
                                                isOpenDonationRequestModal = false
                                            "
                                        >
                                            Cancel
                                        </button>
                                        <button
                                            type="submit"
                                            class="inline-flex justify-center rounded-md border border-transparent px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                            :class="
                                                donationRequestForm.processing
                                                    ? 'bg-indigo-100 cursor-not-allowed'
                                                    : 'bg-indigo-500 hover:bg-indigo-400'
                                            "
                                            :disabled="
                                                donationRequestForm.processing
                                            "
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </AppLayout>
</template>
