<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import SearchInput from "@/Components/SearchInput.vue";
import { Inertia } from "@inertiajs/inertia";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import {
    ChevronUpIcon,
    XMarkIcon,
    ChevronDownIcon,
} from "@heroicons/vue/20/solid";
import { CheckCircleIcon, XCircleIcon } from "@heroicons/vue/24/outline";
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
                            Your donation requests
                            <button
                                class="w-full sm:w-fit text-sm font-semibold px-3 py-1.5 mt-2 mb-2 sm:mt-0 text-white bg-indigo-500 hover:bg-opacity-50 rounded-md"
                            >
                                make new request
                            </button>
                        </div>
                        <DataTable
                            :header-data="[
                                '#',
                                'Title',
                                'Status',
                                'Progress',
                                'Requested Date'
                            ]"
                            :body-data="[]"
                            type="admin"
                        />
                    </div>
                </div>
            </template>
        </div>
    </AppLayout>
</template>
