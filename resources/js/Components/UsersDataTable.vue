<script setup>
defineProps({
    headerData: Array,
    bodyData: Object || Array,
});
</script>

<template>
    <table class="w-full text-left table-collapse">
        <thead>
            <tr>
                <template v-for="hData in headerData" :key="hData">
                    <th class="text-sm font-semibold text-gray-700 p-4 bg-gray-100">
                        {{ hData }}
                    </th>
                </template>
            </tr>
        </thead>
        <template v-if="bodyData.length > 0">
            <tbody>
                <template v-for="bData in bodyData" :key="bData.id">
                    <tr>
                        <td class="p-4 border-t border-gray-200">
                            {{ bData.name }}
                        </td>
                        <td class="p-4 border-t border-gray-200">
                            {{ bData.email }}
                        </td>
                        <td class="p-4 border-t border-gray-200">
                            <a
                                href="#"
                                class="text-xs font-semibold text-indigo-600 hover:text-indigo-800"
                                >Edit</a
                            >
                            <a
                                href="#"
                                class="text-xs font-semibold text-red-600 hover:text-red-800 ml-4"
                                >Delete</a
                            >
                        </td>
                    </tr>
                </template>
            </tbody>
        </template>
        <template v-else>
            <h3 class="text-md font-semibold text-gray-600 p-2">No data</h3>
        </template>
    </table>
</template>
