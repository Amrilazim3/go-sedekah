<script setup>
import { onMounted } from "@vue/runtime-core";
import SearchInput from "@/Components/SearchInput.vue";
import DataTable from "@/Components/DataTable.vue";
import PaginationBar from "@/Components/PaginationBar.vue";
import { ref, computed } from "vue";

const props = defineProps({
    donorData: Object,
    queryParams: Object,
    queryResult: Object,
});

defineEmits(["searchQuery"]);

const searchDonationHistory = ref("");

const histories = computed(() => {
    if (props.queryParams.role == "donor") {
        props.donorData.historiesData.data = props.queryResult;
    }

    return props.donorData.historiesData;
});

onMounted(() => {
    if (props.queryParams.search && props.queryParams.role == "donor") {
        searchDonationHistory.value = props.queryParams.search;
    }
});
</script>

<template>
    <div class="max-w-7xl mx-auto mb-8 sm:px-6 lg:px-8">
        <div class="bg-white p-2 sm:p-4 relative shadow-md sm:rounded-lg">
            <h2 class="text-lg font-semibold">Your donation histories</h2>
            <SearchInput
                :focus-input="
                    props.queryParams.model == 'Donation' &&
                    props.queryParams.role == 'donor'
                        ? true
                        : false
                "
                placeholder="Search receiver / title"
                v-model="searchDonationHistory"
                @input="
                    $emit(
                        'searchQuery',
                        searchDonationHistory,
                        '',
                        'donor',
                        'Donation'
                    )
                "
                @click="
                    $emit(
                        'searchQuery',
                        searchDonationHistory,
                        '',
                        'donor',
                        'Donation'
                    )
                "
            />
            <DataTable
                :header-data="[
                    '#',
                    'Receiver',
                    'Title',
                    'Amount',
                    'Date',
                    'Receipt',
                ]"
                :body-data="histories.data"
                type="histories"
            />
            <PaginationBar :links="histories.links" />
        </div>
    </div>
</template>
