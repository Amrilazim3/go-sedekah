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
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
        <Head title="Welcome" />

        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <ApplicationLogo class="h-8 w-auto" />
                    
                    <div v-if="canLogin" class="flex items-center space-x-4">
                        <Link
                            v-if="$page.props.user"
                            :href="route('dashboard.index')"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 15V9a2 2 0 012-2h4a2 2 0 012 2v6"></path>
                            </svg>
                            Dashboard
                        </Link>

                        <template v-else>
                            <div class="hidden sm:flex items-center space-x-3">
                                <Link
                                    :href="route('login')"
                                    class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors duration-200"
                                >Log in</Link>

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                                >Get Started</Link>
                            </div>

                            <!-- Mobile Menu -->
                            <div class="relative sm:hidden">
                                <Menu>
                                    <MenuButton>
                                        <button class="inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                            </svg>
                                        </button>
                                    </MenuButton>
                                    <MenuItems class="absolute right-0 w-48 mt-2 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                                        <MenuItem as="div" v-slot="{ active }">
                                            <Link
                                                :href="route('login')"
                                                :class="active ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700'"
                                                class="block px-4 py-2 text-sm transition-colors duration-200"
                                            >Log in</Link>
                                        </MenuItem>
                                        <MenuItem as="div" v-slot="{ active }">
                                            <Link
                                                :href="route('register')"
                                                :class="active ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700'"
                                                class="block px-4 py-2 text-sm transition-colors duration-200"
                                            >Register</Link>
                                        </MenuItem>
                                    </MenuItems>
                                </Menu>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-16 overflow-hidden">
            <div class="absolute inset-0">
                <img 
                    src="https://go-sedekah.amrilazim.com/resources/d8f80683-6d12-49cc-a24f-f44853eaaed4.jpeg" 
                    alt="Hero background" 
                    class="w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/80 via-purple-900/70 to-pink-900/80"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                            Bring Hope to
                            <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">Those in Need</span>
                        </h1>
                        <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                            Join our community of compassionate donors and make a real difference in someone's life today.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <!-- redirect to signup page -->
                             
                            <Link
                                :href="route('register')"
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 font-semibold rounded-xl hover:from-yellow-500 hover:to-orange-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    Start Donating
                            </Link>
                        </div>
                    </div>
                    
                    <!-- Recent Donations Card -->
                    <div class="lg:max-w-md mx-auto w-full">
                        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-6 border border-white/20">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-gray-900">Recent Donations</h3>
                                <div class="flex items-center text-green-600">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></div>
                                    <span class="text-sm font-medium">Live</span>
                                </div>
                            </div>
                            
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                <template v-if="recentDonations.length > 0">
                                    <div
                                        v-for="donation in recentDonations"
                                        :key="donation.id"
                                        class="flex items-center p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border border-indigo-100 hover:shadow-md transition-all duration-200"
                                    >
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm text-gray-800">
                                                <span class="font-semibold text-indigo-600">
                                                    {{ donation.is_hidden ? "Anonymous" : donation.user.name }}
                                                </span>
                                                donated
                                                <span class="font-bold text-green-600">RM{{ donation.amount }}</span>
                                            </p>
                                            <p class="text-xs text-gray-500">Just now</p>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="text-center py-8">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-sm">No recent donations</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Donation Requests Section -->
        <section class="py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Active Donation Requests
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Every donation, no matter the size, creates ripples of hope and positive change in our community.
                    </p>
                </div>
                
                <div v-if="donationRequests.data.length > 0" class="space-y-6">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div
                            v-for="request in donationRequests.data"
                            :key="request.id"
                            class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-1"
                        >
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors duration-200">
                                            {{ request.title }}
                                        </h3>
                                        <p class="text-sm text-indigo-600 font-medium">
                                            by {{ request.user.name }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <p class="text-gray-600 mb-6 line-clamp-3">
                                    {{ request.detail }}
                                </p>
                                
                                <!-- Progress Bar -->
                                <div class="mb-6">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-gray-700">Progress</span>
                                        <span class="text-sm font-bold text-indigo-600">{{ request.progress }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div 
                                            class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500 ease-out"
                                            :style="`width: ${parseFloat(request.progress)}%`"
                                        ></div>
                                    </div>
                                    <div class="flex justify-between items-center mt-2 text-sm">
                                        <span class="text-gray-500">RM{{ request.currently_received }} raised</span>
                                        <span class="font-semibold text-gray-900">RM{{ request.target_amount }} goal</span>
                                    </div>
                                </div>
                                
                                <button
                                    @click.prevent="openDonationModel(request.id)"
                                    class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    Donate Now
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-center mt-12">
                        <PaginationBar :links="donationRequests.links" />
                    </div>
                </div>
                
                <div v-else class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No Active Requests</h3>
                        <p class="text-gray-600">There are currently no donation requests available. Check back later for new opportunities to help.</p>
                    </div>
                </div>
            </div>
        </section>

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
