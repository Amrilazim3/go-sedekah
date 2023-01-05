<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SearchInput from "@/Components/SearchInput.vue";
import UsersDataTable from "@/Components/UsersDataTable.vue";
import PaginationBar from "@/Components/PaginationBar.vue";
import { Inertia } from "@inertiajs/inertia";
import { onMounted, reactive, ref, computed } from "vue";
import { debounce } from "lodash";

const props = defineProps({
    usersData: Object,
    filteredData: Array,
    requestedData: Object,
});

const admins = computed(() => {
    if (props.requestedData.name && props.requestedData.role == "admin") {
        props.usersData.admins.data = props.filteredData;
    }
    return props.usersData.admins;
});
const donors = computed(() => {
    if (props.requestedData.name && props.requestedData.role == "donor") {
        props.usersData.donors.data = props.filteredData;
    }
    return props.usersData.donors;
});
const needy = computed(() => {
    if (props.requestedData.name && props.requestedData.role == "needy") {
        props.usersData.needy.data = props.filteredData;
    }
    return props.usersData.needy;
});

const params = reactive({
    name: props.requestedData.name,
    role: props.requestedData.role,
});

const searchAdminValue = ref("");
const searchDonorValue = ref("");
const searchNeedyValue = ref("");

const headerData = ["Name", "Email", "Actions"];

onMounted(() => {
    if (props.requestedData.role == "admin") {
        searchAdminValue.value = props.requestedData.name;
    }

    if (props.requestedData.role == "donor") {
        searchDonorValue.value = props.requestedData.name;
    }

    if (props.requestedData.role == "needy") {
        searchNeedyValue.value = props.requestedData.name;
    }
});

const searchUserByRole = debounce((name, role) => {
    if (!name && !params.name) {
        return;
    }

    params.name = name;
    params.role = role;

    Inertia.get("/admin/users", params, {
        preserveScroll: true,
    });
}, 500);

const approveAdmin = (userId) => {
    console.log("approving user id " + userId + " to become an admin");
};

const approveNeedy = (userId) => {
    Inertia.post(`/admin/users/${userId}/assign-role/needy`, null);
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
                        :focus-input="
                            props.requestedData.role == 'admin' ? true : false
                        "
                        placeholder="Search admin"
                        v-model="searchAdminValue"
                        @input="searchUserByRole(searchAdminValue, 'admin')"
                        @click="searchUserByRole(searchAdminValue, 'admin')"
                    />
                    <UsersDataTable
                        :header-data="headerData"
                        :body-data="admins.data"
                        type="admin"
                    />
                    <template v-if="!props.requestedData.name || props.requestedData.role !== 'admin'">
                        <PaginationBar :links="admins.links" />
                    </template>
                </div>
            </div>

            <!-- donor users -->
            <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-2 overflow-x-scroll shadow-md sm:rounded-lg"
                >
                    <h2 class="text-lg font-semibold">Donors</h2>
                    <SearchInput
                        :focus-input="
                            props.requestedData.role == 'donor' ? true : false
                        "
                        placeholder="Search donor"
                        v-model="searchDonorValue"
                        @input="searchUserByRole(searchDonorValue, 'donor')"
                        @click="searchUserByRole(searchDonorValue, 'donor')"
                    />
                    <UsersDataTable
                        :header-data="headerData"
                        :body-data="donors.data"
                        type="donor"
                        @approve-admin="approveAdmin"
                        @approve-needy="approveNeedy"
                    />
                    <template v-if="!props.requestedData.name || props.requestedData.role !== 'donor'">
                        <PaginationBar :links="donors.links" />
                    </template>
                </div>
            </div>

            <!-- needy users -->
            <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-2 overflow-x-scroll shadow-md sm:rounded-lg"
                >
                    <h2 class="text-lg font-semibold">Needy</h2>
                    <SearchInput
                        :focus-input="
                            props.requestedData.role == 'needy' ? true : false
                        "
                        placeholder="Search donor"
                        v-model="searchNeedyValue"
                        @input="searchUserByRole(searchNeedyValue, 'needy')"
                        @click="searchUserByRole(searchNeedyValue, 'needy')"
                    />
                    <UsersDataTable
                        :header-data="headerData"
                        :body-data="needy.data"
                        type="needy"
                    />
                    <template v-if="!props.requestedData.name || props.requestedData.role !== 'needy'">
                        <PaginationBar :links="needy.links" />
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
