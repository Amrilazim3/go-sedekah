<script setup>
const props = defineProps({
    data: Object,
});
</script>

<template>
    <div class="py-8">
        <div class="border-t border-gray-200" />
    </div>

    <!-- donation received summary -->
    <div>
        <h3 class="text-lg text-gray-800 font-semibold mb-2">
            Donation Request Summary
        </h3>
        <div class="space-y-4">
            <div class="sm:flex">
                <div class="sm:flex-1">
                    <h3 class="text-md font-semibold text-indigo-500">
                        Donation received total :
                    </h3>
                    <h3 class="text-md">
                        {{ props.data.donationReceivedTotalAmount }} MYR
                    </h3>
                </div>
                <div class="sm:flex-1">
                    <h3 class="text-md font-semibold text-indigo-500">
                        Donation request made total :
                    </h3>
                    <h3 class="text-md">
                        {{ props.data.donationRequestsMade }} times
                    </h3>
                </div>
            </div>
            <div class="sm:flex">
                <div class="mt-6 sm:-mt-0 sm:last:flex-1">
                    <h3 class="text-md font-semibold text-indigo-500">
                        Total donator :
                    </h3>
                    <p class="text-md">{{ props.data.totalDonator }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="border-t border-gray-200" />
    </div>

    <!-- Recent donation request -->
    <div>
        <h3 class="text-lg text-gray-800 font-semibold mb-2">
            Recent Donation Request
        </h3>
        <template v-if="props.data.recentDonationRequest">
            <div class="relative rounded-md shadow-sm">
                <div
                    class="px-4 py-5 bg-indigo-100 rounded-tr-md rounded-tl-md sm:p-6"
                >
                    <div
                        class="flex justify-between text-md leading-5 font-medium text-gray-900"
                    >
                        <h3>For my personal medecine</h3>
                        <h3 class="text-gray-600 text-sm">5 November 2021</h3>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                        <div class="sm:flex">
                            <div class="mr-6 text-sm leading-5 text-gray-500">
                                <h4 class="text-gray-700">Details</h4>
                                <p>
                                    My teeth last week broke becauase i eat to
                                    much crab without stop for 3 hours, right
                                    now my teeh is look old lady that need to be
                                    replace and the cost for replacement is so
                                    high
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
                                    $50
                                </dd>
                            </dl>
                            <dl class="sm:ml-4">
                                <dt class="text-sm text-gray-700">
                                    Donation Goals
                                </dt>
                                <dd
                                    class="text-sm leading-5 font-medium text-green-600"
                                >
                                    $100
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-gray-100 rounded-br-md rounded-bl-md px-4 py-4 sm:px-6"
                >
                    <div class="text-sm leading-5">
                        <a
                            href="#"
                            class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out"
                        >
                            View More
                        </a>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <h3>No request is made yet.</h3>
        </template>
    </div>

    <div class="py-8">
        <div class="border-t border-gray-200" />
    </div>

    <!-- Recent donator -->
    <div>
        <h3 class="text-lg text-gray-800 font-semibold">Recent Donator</h3>
        <template v-if="props.data.recentDonator">
            <p class="text-gray-800">
                <span class="text-indigo-500 font-semibold">{{
                    props.data.recentDonator.user.name
                }}</span>
                donated you {{ props.data.recentDonator.amount }} MYR
            </p>
        </template>
        <template v-else><h3>No recent donator.</h3></template>
    </div>
</template>
