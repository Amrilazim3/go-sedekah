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
})

const isOpen = ref(false);

const closeModal = () => {
    return false;
};

const form = useForm({
    name: "",
    bankAccountNumber: "",
    bankAccountIC: "",
    bankCode: "",
});

const submit = () => {
    console.log(form);

    // form.transform((data) => ({
    //     ...data,
    // }));
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
                <div class="px-4 space-y-4">
                    <div>
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
                                            class="py-4 px-6 font-semibold text-sm"
                                        >
                                            Card
                                        </th>
                                        <th
                                            class="py-4 px-6 font-semibold text-sm"
                                        >
                                            Name
                                        </th>
                                        <th
                                            class="py-4 px-6 font-semibold text-sm"
                                        >
                                            Account Number
                                        </th>
                                        <th
                                            class="py-4 px-6 font-semibold text-sm"
                                        >
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd:bg-indigo-100">
                                        <td class="py-4 px-6">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"
                                                />
                                                <path
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                />
                                            </svg>
                                        </td>
                                        <td class="py-4 px-6 text-sm">
                                            John Doe
                                        </td>
                                        <td class="py-4 px-6 text-sm">
                                            XXXX-XXXX-XXXX-1234
                                        </td>
                                        <td class="py-4 px-6">
                                            <div
                                                class="flex space-x-2 text-sm font-semibold"
                                            >
                                                <button class="text-indigo-500">
                                                    edit
                                                </button>
                                                <button class="text-red-500">
                                                    delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-indigo-100">
                                        <td class="py-4 px-6">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"
                                                />
                                                <path
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                />
                                            </svg>
                                        </td>
                                        <td class="py-4 px-6 text-sm">
                                            Jane Smith
                                        </td>
                                        <td class="py-4 px-6 text-sm">
                                            XXXX-XXXX-XXXX-5678
                                        </td>
                                        <td class="py-4 px-6">
                                            <div
                                                class="flex space-x-2 text-sm font-semibold"
                                            >
                                                <button class="text-indigo-500">
                                                    edit
                                                </button>
                                                <button class="text-red-500">
                                                    delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end mt-3">
                            <!-- when button click open modal screen using headless u.i -->
                            <button
                                class="text-sm font-semibold bg-indigo-200 hover:bg-indigo-300 text-gray-600 rounded-md px-3 py-2"
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
                                                v-model="form.bankAccountIC"
                                                type="text"
                                                class="mt-1 block w-full"
                                                required
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="
                                                    form.errors.bankAccountIC
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
                                        <div
                                            class="flex justify-end space-x-1.5 mt-4"
                                        >
                                            <button
                                                type="button"
                                                class="inline-flex justify-center rounded-md border border-transparent bg-red-100 px-4 py-2 text-sm font-medium text-gray-800 hover:bg-red-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2"
                                                @click="isOpen = false"
                                            >
                                                Cancel
                                            </button>
                                            <button
                                                type="submit"
                                                class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
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
