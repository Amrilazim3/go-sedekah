<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import { ref } from "vue";

defineProps({
    banksName: Array,
    banks: Array,
});

const isOpen = ref(false);

const closeModal = () => {
    return false;
};

const form = useForm({
    name: "",
    bankAccountNumber: "",
    bankAccountIc: "",
    bankCode: "",
});

const submit = () => {
    form.transform((data) => ({
        ...data,
    })).post(route("needy.banks.store"), {
        preserveScroll: true,
        onSuccess: () => {
            isOpen.value = false;
            form.reset();
        },
    });
};
</script>

<template>
    <AppLayout title="Banks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Banks
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="space-y-4">
                    <div class="px-4">
                        <h3 class="text-md">Your banks</h3>
                        <p class="text-sm text-gray-700">
                            View and setup your banks used to received a
                            donation.
                        </p>
                    </div>
                    <div class="bg-white shadow-md px-4 py-3">
                        <div class="bg-indigo-50 rounded-md overflow-x-scroll">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-indigo-500 text-white">
                                        <th
                                            class="py-4 px-6 whitespace-nowrap font-semibold text-sm"
                                        >
                                            #
                                        </th>
                                        <th
                                            class="py-4 px-6 whitespace-nowrap font-semibold text-sm"
                                        >
                                            Name
                                        </th>
                                        <th
                                            class="py-4 px-6 whitespace-nowrap font-semibold text-sm"
                                        >
                                            Account Number
                                        </th>
                                        <th
                                            class="py-4 px-6 whitespace-nowrap font-semibold text-sm"
                                        >
                                            Identity Card Number
                                        </th>
                                        <th
                                            class="py-4 px-6 whitespace-nowrap font-semibold text-sm"
                                        >
                                            Status
                                        </th>
                                        <th
                                            class="py-4 px-6 whitespace-nowrap font-semibold text-sm"
                                        >
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="banks.length > 0">
                                        <template
                                            v-for="(bank, key) in banks"
                                            :key="bank.id"
                                        >
                                            <tr class="odd:bg-indigo-100">
                                                <td
                                                    class="py-4 px-6 whitespace-nowrap text-sm"
                                                >
                                                    {{ key + 1 }}
                                                </td>
                                                <td
                                                    class="py-4 px-6 whitespace-nowrap text-sm"
                                                >
                                                    {{ bank.name_on_card }}
                                                </td>
                                                <td
                                                    class="py-4 px-6 whitespace-nowrap text-sm"
                                                >
                                                    {{ bank.account_number }}
                                                </td>
                                                <td
                                                    class="py-4 px-6 whitespace-nowrap text-sm"
                                                >
                                                    {{ bank.ic_number }}
                                                </td>
                                                <td
                                                    class="py-4 px-6 whitespace-nowrap text-sm font-semibold"
                                                    :class="
                                                        bank.is_verified
                                                            ? 'text-green-500'
                                                            : 'text-orange-500'
                                                    "
                                                >
                                                    {{
                                                        bank.is_verified
                                                            ? "verified"
                                                            : "pending"
                                                    }}
                                                </td>
                                                <td
                                                    class="py-4 px-6 whitespace-nowrap"
                                                >
                                                    <div
                                                        class="flex space-x-2 text-sm font-semibold"
                                                    >
                                                        <button
                                                            class="px-3 py-1 bg-gray-50 hover:bg-gray-100 rounded-md text-red-500"
                                                        >
                                                            delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <h3 class="my-2 text-md px-2">
                                            No data
                                        </h3>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end mt-3">
                            <!-- when button click open modal screen using headless u.i -->
                            <button
                                class="text-sm font-semibold bg-indigo-500 hover:bg-indigo-400 text-white rounded-md px-3 py-2"
                                @click="isOpen = true"
                            >
                                add new bank
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <TransitionRoot appear :show="isOpen" as="template">
                <Dialog as="div" @close="closeModal" class="relative z-10">
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
                                            Add New Bank
                                        </DialogTitle>
                                        <div class="mt-4">
                                            <InputLabel
                                                for="name"
                                                value="Name on card"
                                            />
                                            <TextInput
                                                id="name"
                                                v-model="form.name"
                                                type="text"
                                                class="mt-1 block w-full"
                                                required
                                                autofocus
                                                placeholder="ali bin abu"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.name"
                                            />
                                        </div>
                                        <div class="mt-4">
                                            <InputLabel
                                                for="bank-acc-number"
                                                value="Bank account number"
                                            />
                                            <TextInput
                                                id="bank-acc-number"
                                                v-model="form.bankAccountNumber"
                                                type="text"
                                                class="mt-1 block w-full"
                                                required
                                                placeholder="15158221292"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="
                                                    form.errors
                                                        .bankAccountNumber
                                                "
                                            />
                                        </div>
                                        <div class="mt-4">
                                            <InputLabel
                                                for="bank-acc-ic"
                                                value="Bank account identity card"
                                            />
                                            <TextInput
                                                id="bank-acc-ic"
                                                v-model="form.bankAccountIc"
                                                type="text"
                                                class="mt-1 block w-full"
                                                required
                                                placeholder="080908010922"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="
                                                    form.errors.bankAccountIc
                                                "
                                            />
                                        </div>
                                        <div class="mt-4">
                                            <InputLabel
                                                for="bank-name"
                                                value="Bank name"
                                            />
                                            <SelectInput
                                                id="bank-name"
                                                v-model="form.bankCode"
                                                :data="banksName"
                                                class="mt-1 block w-full"
                                                required
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.bankCode"
                                            />
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-700">
                                                Your card will be validated
                                                within 3 days before can be use to
                                                receive donation in our
                                                application.
                                            </p>
                                        </div>
                                        <div
                                            class="flex justify-end space-x-1.5 mt-4"
                                        >
                                            <button
                                                type="button"
                                                class="inline-flex justify-center rounded-md border border-transparent bg-red-500 px-4 py-2 text-sm font-medium text-gray-800 hover:bg-red-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2"
                                                @click="isOpen = false"
                                            >
                                                Cancel
                                            </button>
                                            <button
                                                type="submit"
                                                class="inline-flex justify-center rounded-md border border-transparent px-4 py-2 text-sm font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                                :class="
                                                    form.processing
                                                        ? 'bg-indigo-100 cursor-not-allowed'
                                                        : 'bg-indigo-500 hover:bg-indigo-400'
                                                "
                                                :disabled="form.processing"
                                            >
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
        </div>
    </AppLayout>
</template>
