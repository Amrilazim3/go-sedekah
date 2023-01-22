<script setup>
import { onMounted } from "@vue/runtime-core";
import SearchInput from "@/Components/SearchInput.vue";
import DataTable from "@/Components/DataTable.vue";
import PaginationBar from "@/Components/PaginationBar.vue";
import { ref, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { inject } from "vue";

const props = defineProps({
    needyData: Object,
    queryParams: Object,
    queryResult: Object,
});

defineEmits(["searchQuery", "statusQuery"]);

const Swal = inject("$swal");

const isOpenDonationRequestModal = ref(false);
const searchDonationRequest = ref("");

const donationRequestForm = useForm({
    title: "",
    detail: "",
    targetAmount: null,
    bankAccountId: null,
});

const hasBankAccounts = computed(() => {
    if (props.needyData.bankAccounts.length > 0) {
        return true;
    }

    return false;
});

const requests = computed(() => {
    if (
        props.queryParams.role == "needy" &&
        props.queryParams.model == "DonationRequest"
    ) {
        props.queryParams.search
            ? (props.needyData.requestsData.data = props.queryResult)
            : (props.needyData.requestsData = props.queryResult);
    }

    return props.needyData.requestsData;
});

const submitDonationRequest = () => {
    donationRequestForm
        .transform((data) => ({
            ...data,
        }))
        .post(route("donationRequest.store"), {
            preserveScroll: false,
            onSuccess: () => {
                isOpenDonationRequestModal.value = false;
                donationRequestForm.reset();
            },
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
            Inertia.delete(`/donation-request/${id}`, {
                preserveScroll: false,
            });
        }
    });
};

onMounted(() => {
    if (
        props.queryParams.search &&
        props.queryParams.role == "needy" &&
        props.queryParams.model == "DonationRequest"
    ) {
        searchDonationRequest.value = props.queryParams.search;
    }
});
</script>

<template>
    <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
        <div class="bg-white p-2 sm:p-4 relative shadow-md sm:rounded-lg">
            <div class="text-lg sm:flex sm:justify-between font-semibold">
                <h2 class="text-lg font-semibold">Your donation requests</h2>
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
                        props.queryParams.search &&
                        props.queryParams.role == 'needy' &&
                        props.queryParams.model == 'DonationRequest'
                            ? true
                            : false
                    "
                    placeholder="search donation title"
                    class="sm:w-full"
                    v-model="searchDonationRequest"
                    @input="
                        $emit(
                            'searchQuery',
                            searchDonationRequest,
                            '',
                            'needy',
                            'DonationRequest'
                        )
                    "
                    @click="
                        $emit(
                            'searchQuery',
                            searchDonationRequest,
                            '',
                            'needy',
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
                                                'needy',
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
                                                'needy',
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
                                                'needy',
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
                                                'needy',
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
                            <form @submit.prevent="submitDonationRequest">
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
                                    <InputLabel for="detail" value="Detail" />
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
                                            donationRequestForm.errors.detail
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
                                        :data="props.needyData.bankAccounts"
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
                                        You must wait for an admin to approve
                                        your request after making this request.
                                    </p>
                                    <p class="text-sm mt-2 text-gray-600">
                                        You can delete your donation request
                                        while it is in pending state, after the
                                        request is approved, it can't be
                                        deleted.
                                    </p>
                                </div>
                                <div class="flex justify-end space-x-1.5 mt-4">
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
</template>
