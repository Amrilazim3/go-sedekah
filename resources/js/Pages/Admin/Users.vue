<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SearchInput from "@/Components/SearchInput.vue";
import UsersDataTable from "@/Components/UsersDataTable.vue";
import { Inertia } from "@inertiajs/inertia";
import { reactive, ref } from "vue";

const props = defineProps({
    usersData: Object,
});

const admins = reactive(props.usersData.admins);
const donors = reactive(props.usersData.donors.data);
const needy = reactive(props.usersData.needy.data);

const searchAdminValue = ref("");
const searchDonorValue = ref("");
const searchNeedyValue = ref("");

const headerData = ['Name', 'Email', 'Actions'];

// futrue feature (use debounce)
const searchUserByRole = (name) => {
    console.log(name);
};
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
                    class="bg-white p-2 overflow-x-scroll shadow-md sm:rounded-lg"
                >
                    <h2 class="text-lg font-semibold">Admins</h2>
                    <SearchInput
                        placeholder="Search admin"
                        v-model="searchAdminValue"
                        @keydown="searchUserByRole('admin')"
                    />
                    <UsersDataTable
                        :header-data="headerData"
                        :body-data="admins"
                        type="admin"
                    />
                </div>
            </div>

            <!-- donor users -->
            <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-2 overflow-x-scroll shadow-md sm:rounded-lg"
                >
                    <h2 class="text-lg font-semibold">Donors</h2>
                    <SearchInput
                        placeholder="Search donor"
                        v-model="searchDonorValue"
                        @keydown="searchUserByRole('donor')"
                    />
                    <UsersDataTable
                        :header-data="headerData"
                        :body-data="donors"
                        type="donor"
                    />
                </div>
            </div>

            <!-- needy users -->
            <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-2 overflow-x-scroll shadow-md sm:rounded-lg"
                >
                    <h2 class="text-lg font-semibold">Needy</h2>
                    <SearchInput
                        placeholder="Search donor"
                        v-model="searchNeedyValue"
                        @keydown="searchUserByRole('needy')"
                    />
                    <UsersDataTable
                        :header-data="headerData"
                        :body-data="needy"
                        type="needy"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
