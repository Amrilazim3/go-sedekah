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
import { reactive, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

defineProps({
    bankAccounts: Array,
    histories: Object,
    requests: Object || Array,
    users: Object || Array,
});

const isOpenDonationRequestModal = ref(false);

const donationRequestForm = useForm({
    title: "",
    detail: "",
    targetAmount: null,
    bankAccountId: null,
});
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
                    <h2 class="text-lg font-semibold">Your histories</h2>
                    <SearchInput
                        :focus-input="false"
                        placeholder="Search name / title / amount"
                        v-model="searchAdminValue"
                    />
                    <DataTable
                        :header-data="[
                            'Name',
                            'Title',
                            'Date',
                            'Amount',
                            'Receipt',
                        ]"
                        :body-data="[]"
                        type="admin"
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
                                :focus-input="false"
                                placeholder="Search needy's name / title"
                                class="sm:w-full"
                                v-model="searchAdminValue"
                            />
                            <!-- dropdwon option -->
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
                                                        'group text-indigo-500 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                    ]"
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
                            <!-- request 1 (pending request) -->
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
                                            Abu kamil
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
                                            For new teeth treatment
                                        </h3>
                                        <h3 class="text-gray-600 text-sm">
                                            5 November 2021
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
                                                            Details
                                                        </h4>
                                                        <p>
                                                            My teeth last week
                                                            broke becauase i eat
                                                            to much crab without
                                                            stop for 3 hours,
                                                            right now my teeh is
                                                            look old lady that
                                                            need to be replace
                                                            and the cost for
                                                            replacement is so
                                                            high
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
                            </div>
                            <!-- request 2 (approved request) -->
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
                                            Ahmad daud
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
                                            For my son's eye operation
                                        </h3>
                                        <h3 class="text-gray-600 text-sm">
                                            5 November 2021
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
                                                            Details
                                                        </h4>
                                                        <p>
                                                            Lorem, ipsum dolor
                                                            sit amet consectetur
                                                            adipisicing elit.
                                                            Dolores maiores
                                                            suscipit impedit id
                                                            in pariatur expedita
                                                            distinctio
                                                            exercitationem quas
                                                            numquam tenetur.
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
                                                            $100
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
                                        >
                                            Approve
                                            <CheckCircleIcon
                                                class="h-4 w-4 ml-1.5 self-center"
                                            />
                                        </button>
                                        <button
                                            class="text-red-500 inline-flex"
                                        >
                                            Reject
                                            <XCircleIcon
                                                class="h-4 w-4 ml-1.5 self-center"
                                            />
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- request 3 (rejected request) -->
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
                                            Ammar asri wak doyok
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
                                            Buy new game for my laptop
                                        </h3>
                                        <h3 class="text-gray-600 text-sm">
                                            5 january 2021
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
                                                            Details
                                                        </h4>
                                                        <p>
                                                            Lorem, ipsum dolor
                                                            sit amet consectetur
                                                            adipisicing elit.
                                                            Dolores maiores
                                                            suscipit impedit id
                                                            in pariatur expedita
                                                            distinctio
                                                            exercitationem quas
                                                            numquam tenetur.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </DisclosurePanel>
                                    </Disclosure>
                                </div>
                            </div>
                        </div>
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
                            :focus-input="false"
                            placeholder="Search donator / receiver / title"
                            v-model="searchAdminValue"
                        />
                        <DataTable
                            :header-data="[
                                'Donator',
                                'Receiver',
                                'Title',
                                'Amount',
                            ]"
                            :body-data="[]"
                            type="admin"
                        />
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
                            <button
                                class="w-full sm:w-fit text-sm font-semibold px-3 py-1.5 mt-2 mb-2 sm:mt-0 text-white bg-indigo-500 hover:bg-opacity-50 rounded-md"
                                @click="isOpenDonationRequestModal = true"
                            >
                                make new request
                            </button>
                        </div>
                        <div class="sm:flex sm:space-x-1.5">
                            <SearchInput
                                :focus-input="false"
                                placeholder="search donation title"
                                class="sm:w-full"
                                v-model="searchAdminValue"
                            />
                            <!-- dropdwon option -->
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
                                                        'group text-indigo-500 flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                    ]"
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
                                'Status',
                                'Progress',
                                'Requested Date',
                            ]"
                            :body-data="[]"
                            type="admin"
                        />
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
                                            :data="[
                                                ['1111', '151584282718'],
                                                ['2222', '992288811222'],
                                            ]"
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
                                        <p class="text-sm text-gray-700">
                                            You must wait for an admin to
                                            approve your request after making
                                            this request.
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
