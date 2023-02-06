<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Footer from "@/Components/Footer.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { computed, onMounted, reactive, ref } from "vue";
import PaginationBar from "@/Components/PaginationBar.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import { inject } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    donationRequestsData: Object,
    recentDonationsData: Object,
});

const Swal = inject("$swal");

const donationRequests = computed(() => {
    return props.donationRequestsData;
});
const recentDonations = reactive(props.recentDonationsData);
const isOpenDonationModel = ref(false);
const currentOpenDonationId = ref(0);
const donationForm = useForm({
    name: usePage().props.value.user?.name || "",
    email: usePage().props.value.user?.email || "",
    amount: "",
    message: "",
    isHidden: false,
});

const openDonationModel = (id) => {
    isOpenDonationModel.value = true;
    currentOpenDonationId.value = id;
};

const closeDonationModel = () => {
    isOpenDonationModel.value = false;
    currentOpenDonationId.value = 0;
    donationForm.reset();
};

const donate = () => {
    donationForm
        .transform((data) => ({
            ...data,
        }))
        .post(`/donations/${currentOpenDonationId.value}`, {
            preserveScroll: true,
            onSuccess: () => {
                Swal.fire({
                    title: "Redirecting to payment page",
                    html: "please wait for a moment...",
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                });

                const billUrl =
                    usePage().props.value.jetstream.flash?.billplzID;

                window.location.href = billUrl;
            },
        });
};

Echo.channel("donation").listen("RecentDonation", (e) => {
    console.log(e);

    if (
        e.donation.id == recentDonations[0].id
    ) {
        return false;
    }

    recentDonations.pop();

    recentDonations.unshift(e.donation);
});

onMounted(() => {
    usePage().props.value.jetstream.flash?.successPayment
        ? Swal.fire({
              icon: "success",
              title: "Success",
              text: "Payment successful, thank you for your support.",
              showCancelButton: false,
          })
        : "";

    usePage().props.value.jetstream.flash?.successPayment == false
        ? Swal.fire({
              icon: "error",
              title: "Failed",
              text: "Your payment cannot be process.",
              showCancelButton: false,
          })
        : "";
});
</script>

<template>
    <div>
        <Head title="Welcome" />

        <div class="relative flex min-h-screen bg-white">
            <div>
                <div
                    class="flex w-full justify-between p-2 fixed top-0 bg-gray-900"
                >
                    <ApplicationLogo class="self-start" />

                    <div v-if="canLogin" class="self-center">
                        <Link
                            v-if="$page.props.user"
                            :href="route('dashboard.index')"
                            class="text-sm text-indigo-500 rounded-md outline-none bg-white p-2 hover:bg-indigo-500 hover:text-white"
                            >Dashboard</Link
                        >

                        <template v-else>
                            <div class="hidden sm:block">
                                <Link
                                    :href="route('login')"
                                    class="text-sm text-indigo-500 rounded-md outline-none bg-white p-2 hover:bg-indigo-500 hover:text-white"
                                    >Log in</Link
                                >

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="ml-2 text-sm text-indigo-500 rounded-md outline-none bg-white p-2 hover:bg-indigo-500 hover:text-white"
                                    >Register</Link
                                >
                            </div>

                            <!-- Hamburger -->
                            <div class="relative sm:hidden">
                                <Menu>
                                    <MenuButton>
                                        <button
                                            class="inline-flex items-center justify-center p-2 bg-gray-100 text-gray-500 rounded-md focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
                                        >
                                            <svg
                                                class="h-6 w-6"
                                                stroke="currentColor"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h16"
                                                />
                                            </svg></button
                                    ></MenuButton>
                                    <MenuItems
                                        class="absolute right-0 w-32 rounded-md p-2 mt-3 bg-gray-900"
                                    >
                                        <MenuItem as="div" v-slot="{ active }">
                                            <Link
                                                :href="route('login')"
                                                :class="{
                                                    'text-indigo-500': active,
                                                    'text-white': !active,
                                                }"
                                                class="flex"
                                            >
                                                login
                                            </Link>
                                        </MenuItem>
                                        <MenuItem as="div" v-slot="{ active }">
                                            <Link
                                                :href="route('register')"
                                                :class="{
                                                    'text-indigo-500': active,
                                                    'text-white': !active,
                                                }"
                                                class="flex"
                                            >
                                                register
                                            </Link>
                                        </MenuItem>
                                    </MenuItems>
                                </Menu>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <main class="mt-14 w-full">
                <div
                    style="
                        background-image: url(http://localhost/resources/d8f80683-6d12-49cc-a24f-f44853eaaed4.jpeg);
                        background-repeat: no-repeat;
                        background-position: center center;
                        background-size: cover;
                    "
                    class="p-3 sm:py-8 sm:flex sm:justify-around"
                >
                    <div
                        class="sm:text-center sm:flex sm:items-center sm:justify-center"
                    >
                        <div>
                            <h3 class="text-xl font-semibold">
                                Bring lights to someone who in the dark!
                            </h3>
                            <p class="text-white font-semibold">
                                Donate now and help the community!
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 sm:-mt-0 lg:w-full lg:max-w-sm">
                        <div class="bg-gray-400 p-3 rounded-md">
                            <h3
                                class="text-lg font-semibold text-center pb-3 text-gray-800"
                            >
                                Recent Donator
                            </h3>
                            <div class="divide-y divide-gray-100 space-y-2">
                                <template v-if="recentDonations.length > 0">
                                    <template
                                        v-for="donation in recentDonations"
                                        :key="donation.id"
                                    >
                                        <div class="p-1 bg-white rounded-md">
                                            <p>
                                                <span class="text-indigo-500">
                                                    {{
                                                        donation.is_hidden
                                                            ? "Someone"
                                                            : donation.user.name
                                                    }}
                                                </span>
                                                just donated
                                                {{ donation.amount }} MYR
                                            </p>
                                        </div>
                                    </template>
                                </template>
                                <template v-else> </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 w-full flex justify-center md:p-6 lg:p-10">
                    <div class="mx-auto py-8">
                        <h2 class="text-lg font-medium mb-4">
                            Available Donation Requests
                        </h2>
                        <div
                            class="bg-gray-200 rounded-lg shadow-md p-4 md:grid md:grid-cols-3"
                        >
                            <template v-if="donationRequests.data.length > 0">
                                <template
                                    v-for="request in donationRequests.data"
                                    :key="request.id"
                                >
                                    <div
                                        class="mb-4 md:col-span-1 md:pr-3 lg:pr-5"
                                    >
                                        <h3 class="text-lg font-medium">
                                            {{ request.title }}
                                            <span
                                                class="text-sm font-light text-indigo-500"
                                                >{{ request.user.name }}</span
                                            >
                                        </h3>
                                        <p class="text-gray-600 mt-1">
                                            {{ request.detail }}
                                        </p>
                                        <div
                                            class="mt-3 flex justify-end space-x-3"
                                        >
                                            <div
                                                class="self-end text-xs text-gray-600"
                                            >
                                                <span class="text-indigo-500">{{
                                                    request.progress
                                                }}</span>
                                                ({{
                                                    request.currently_received
                                                }}
                                                MYR /
                                                {{ request.target_amount }} MYR)
                                            </div>
                                            <button
                                                class="bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600"
                                                @click.prevent="
                                                    openDonationModel(
                                                        request.id
                                                    )
                                                "
                                            >
                                                Donate
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <PaginationBar
                                    :links="donationRequests.links"
                                />
                            </template>
                            <template v-else>
                                <p class="text-lg font-semibold">
                                    No donation requests yet...
                                </p>
                            </template>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <Footer />
    </div>

    <TransitionRoot appear :show="isOpenDonationModel" as="template">
        <Dialog as="div" @close="closeDonationModel" class="relative z-10">
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
                            <form @submit.prevent="donate()">
                                <DialogTitle
                                    as="h3"
                                    class="text-lg font-medium leading-6 text-gray-900"
                                >
                                    Donate form
                                </DialogTitle>
                                <div class="mt-4">
                                    <InputLabel for="name" value="Name" />
                                    <TextInput
                                        id="name"
                                        v-model="donationForm.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                        :autofocus="!$page.props.user"
                                        :readonly="$page.props.user"
                                        placeholder="john doe"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="donationForm.errors.name"
                                    />
                                </div>
                                <div class="mt-4">
                                    <InputLabel
                                        for="email"
                                        value="Email Address"
                                    />
                                    <TextInput
                                        id="email"
                                        v-model="donationForm.email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        required
                                        :readonly="$page.props.user"
                                        placeholder="johndoe@gmail.com"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="donationForm.errors.email"
                                    />
                                </div>
                                <div class="mt-4">
                                    <InputLabel for="amount" value="Amount" />
                                    <TextInput
                                        id="amount"
                                        v-model="donationForm.amount"
                                        type="number"
                                        class="mt-1 block w-full"
                                        required
                                        :autofocus="$page.props.user"
                                        placeholder="50"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="donationForm.errors.amount"
                                    />
                                </div>
                                <div class="mt-4">
                                    <InputLabel for="message" value="Message" />
                                    <TextAreaInput
                                        id="message"
                                        v-model="donationForm.message"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="donationForm.errors.message"
                                    />
                                </div>
                                <div class="mt-4 flex">
                                    <Checkbox
                                        id="is-hidden"
                                        v-model:checked="donationForm.isHidden"
                                        class="self-center"
                                    />

                                    <div
                                        class="ml-2 self-center text-sm text-gray-600"
                                    >
                                        hide the donator information (anymous)
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-1.5 mt-4">
                                    <button
                                        type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-red-500 px-4 py-2 text-sm font-medium text-gray-800 hover:bg-red-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2"
                                        @click="closeDonationModel"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        :class="
                                            donationForm.processing
                                                ? 'bg-indigo-100 cursor-not-allowed'
                                                : 'bg-indigo-500 hover:bg-indigo-400'
                                        "
                                        :disabled="donationForm.processing"
                                    >
                                        Submit
                                    </button>
                                </div>
                                <template
                                    v-if="$page.props.errors.billplzError"
                                >
                                    <InputError
                                        class="mt-2"
                                        :message="
                                            $page.props.errors.billplzError[0]
                                        "
                                    />
                                </template>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
