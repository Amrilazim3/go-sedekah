<script setup>
const props = defineProps({
    data: Object,
});
</script>

<template>
    <div>
        <h3 class="text-lg text-gray-800 font-semibold mb-2">Personal</h3>
        <div class="sm:flex">
            <div class="sm:flex-1">
                <h3 class="text-md font-semibold text-indigo-500">
                    Donated amount total :
                </h3>
                <h3 class="text-md">
                    {{ props.data.totalDonationAmount }} MYR
                </h3>
            </div>
            <div class="mt-6 sm:-mt-0 sm:last:flex-1">
                <h3 class="text-md font-semibold text-indigo-500">
                    Your last donation :
                </h3>
                <template v-if="props.data.recentDonation">
                    <h3 class="text-md">
                        {{ props.data.recentDonation.created_at }} -
                        {{ props.data.recentDonation.amount }} MYR
                        <span class="text-indigo-500">
                            ({{
                                props.data.recentDonation.donation_request.user
                                    .name
                            }})
                        </span>
                    </h3>
                </template>
                <template v-else>
                    <h3>No donation made yet.</h3>
                </template>
            </div>
        </div>
    </div>
</template>
