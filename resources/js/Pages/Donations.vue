<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { debounce, pickBy } from "lodash";
import Donor from "@/Components/DonationByRoles/Donor.vue";
import Admin from "@/Components/DonationByRoles/Admin.vue";
import Needy from "@/Components/DonationByRoles/Needy.vue";

const props = defineProps({
    dataRoles: Object,
    queryResult: Object || Array,
    queryParams: Object,
});

const queryBuilder = debounce((search = "", status = "", role, model) => {
    let isPrimaryQueryKeyExists = search || status ? true : false;

    if (!isPrimaryQueryKeyExists && props.queryParams.role) {
        Inertia.get("/donations", {}, {
            preserveScroll: true,
        });

        return;
    }

    if (isPrimaryQueryKeyExists || props.queryParams.role) {
        let queryParamsObj = pickBy({
            search: search,
            status: status,
            role: role,
            model: model,
        });

        Inertia.get("/donations", queryParamsObj, {
            preserveScroll: true,
        });

        return;
    }
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
            <template v-if="$page.props.inertia.user.roles.includes('donor')">
                <Donor
                    :donorData="props.dataRoles['donor']"
                    :queryParams="props.queryParams"
                    :queryResult="props.queryResult"
                    @searchQuery="queryBuilder"
                />
            </template>

            <template v-if="$page.props.inertia.user.roles.includes('admin')">
                <Admin 
                    :adminData="props.dataRoles['admin']"
                    :queryParams="props.queryParams"
                    :queryResult="props.queryResult"
                    @searchQuery="queryBuilder"
                    @statusQuery="queryBuilder"
                />
            </template>

            <template v-if="$page.props.inertia.user.roles.includes('needy')">
                <Needy 
                    :needyData="props.dataRoles['needy']"
                    :queryParams="props.queryParams"
                    :queryResult="props.queryResult"
                    @searchQuery="queryBuilder"
                    @statusQuery="queryBuilder"
                />
            </template>
        </div>
    </AppLayout>
</template>
