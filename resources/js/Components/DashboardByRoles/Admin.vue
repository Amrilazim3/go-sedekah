<script setup>
const props = defineProps({
    data: Object,
});
</script>

<template>
    <div class="py-8">
        <div class="border-t border-gray-200" />
    </div>

    <!-- summary -->
    <div>
        <h3 class="text-lg text-gray-800 font-semibold mb-2">
            Donation Summary
        </h3>
        <div class="space-y-4">
            <div class="sm:flex">
                <div class="sm:flex-1">
                    <h3 class="text-md font-semibold text-indigo-500">
                        Accumulated donation :
                    </h3>
                    <h3 class="text-md">
                        {{ props.data.accumulatedDonation }} MYR
                    </h3>
                </div>
                <div class="mt-6 sm:-mt-0 sm:last:flex-1">
                    <h3 class="text-md font-semibold text-indigo-500">
                        This month accumulated donation :
                    </h3>
                    <p class="text-md">
                        {{ props.data.thisMonthAccumulatedDonation }} MYR
                    </p>
                </div>
            </div>
            <div class="sm:flex">
                <div class="sm:flex-1">
                    <h3 class="text-md font-semibold text-indigo-500">
                        This month total donors :
                    </h3>
                    <h3 class="text-md">{{ props.data.thisMonthDonors }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="border-t border-gray-200" />
    </div>

    <!-- recent donation request -->
    <div>
        <h3 class="text-lg text-gray-800 font-semibold mb-2">
            Recent Approved Donation Requests
        </h3>
        <div class="relative rounded-md shadow-sm">
            <div
                class="px-4 py-5 bg-indigo-100 rounded-tr-md rounded-tl-md sm:p-6"
            >
                <div class="flex items-center justify-between">
                    <div
                        class="text-md font-semibold leading-5 text-indigo-500"
                    >
                        {{ props.data.recentApprovedDonationRequest.user.name }}
                    </div>
                </div>
                <div class="mt-2 flex justify-between leading-5">
                    <h3 class="text-md font-medium text-gray-900 underline">
                        {{ props.data.recentApprovedDonationRequest.title }}
                    </h3>
                    <h3 class="text-gray-600 text-sm">
                        {{
                            props.data.recentApprovedDonationRequest.created_at
                        }}
                    </h3>
                </div>
                <div class="mt-2 sm:flex sm:justify-between">
                    <div class="sm:flex">
                        <div class="mr-6 text-sm leading-5 text-gray-500">
                            <h4 class="text-gray-700">Details</h4>
                            <p>
                                {{
                                    props.data.recentApprovedDonationRequest
                                        .detail
                                }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="mt-4 sm:mt-0 sm:ml-4 sm:flex-shrink-0 sm:flex sm:justify-end"
                    >
                        <dl>
                            <dt class="text-sm text-gray-700">
                                Current Donation Received
                            </dt>
                            <dd
                                class="text-sm leading-5 font-medium text-blue-600"
                            >
                                {{
                                    props.data.recentApprovedDonationRequest
                                        .currently_received
                                }}
                            </dd>
                        </dl>
                        <dl class="sm:ml-4">
                            <dt class="text-sm text-gray-700">
                                Donation Goals
                            </dt>
                            <dd
                                class="text-sm leading-5 font-medium text-green-600"
                            >
                                {{
                                    props.data.recentApprovedDonationRequest
                                        .target_amount
                                }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="border-t border-gray-200" />
    </div>

    <!-- total users -->
    <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Total Users</h2>
        <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <div class="text-gray-600 font-semibold text-md">Admin</div>
                <div class="text-gray-800 font-semibold text-md">
                    {{ props.data.totalUsers.admin }}
                </div>
            </div>
            <div class="flex justify-between items-center mb-4">
                <div class="text-gray-600 font-semibold text-md">Donor</div>
                <div class="text-gray-800 font-semibold text-md">
                    {{ props.data.totalUsers.donor }}
                </div>
            </div>
            <div class="flex justify-between items-center mb-4">
                <div class="text-gray-600 font-semibold text-md">Needy</div>
                <div class="text-gray-800 font-semibold text-md">
                    {{ props.data.totalUsers.needy }}
                </div>
            </div>
        </div>
    </div>
</template>
