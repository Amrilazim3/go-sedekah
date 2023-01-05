<script setup>
import { EllipsisVerticalIcon } from "@heroicons/vue/20/solid";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";

defineProps({
    headerData: Array,
    bodyData: Object || Array,
    type: String,
});
 
defineEmits([
    "removeAdmin",
    "approveAdmin",
    "approveNeedy",
    "removeNeedy"
]);
</script>

<template>
    <table class="w-full text-left table-collapse">
        <thead>
            <tr>
                <template v-for="hData in headerData" :key="hData">
                    <th
                        class="text-sm font-semibold text-gray-700 p-4 bg-gray-100"
                    >
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
                            <!-- admin actions -->
                            <template
                                v-if="
                                    type == 'admin' &&
                                    $page.props.user.email ==
                                        'go.sedekah0711@gmail.com' &&
                                    bData.email != 'go.sedekah0711@gmail.com'
                                "
                            >
                                <Menu>
                                    <MenuButton>
                                        <EllipsisVerticalIcon
                                            class="h-5 w-5 cursor-pointer"
                                        />
                                    </MenuButton>
                                    <transition
                                        enter-active-class="transition duration-100 ease-out"
                                        enter-from-class="transform scale-95 opacity-0"
                                        enter-to-class="transform scale-100 opacity-100"
                                        leave-active-class="transition duration-75 ease-in"
                                        leave-from-class="transform scale-100 opacity-100"
                                        leave-to-class="transform scale-95 opacity-0"
                                    >
                                        <MenuItems
                                            class="sm:absolute z-40 mt-1 origin-top-left divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        >
                                            <div class="px-1 py-1">
                                                <MenuItem v-slot="{ active }">
                                                    <button
                                                        :class="[
                                                            active
                                                                ? 'bg-indigo-500 text-white'
                                                                : 'text-gray-900',
                                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                        ]"
                                                        @click="$emit('removeAdmin', bData.id)"
                                                    >
                                                        Remove from admin
                                                    </button>
                                                </MenuItem>
                                            </div>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                            </template>
                            <!-- donor actions -->
                            <template v-if="type == 'donor'">
                                <Menu>
                                    <MenuButton>
                                        <EllipsisVerticalIcon
                                            class="h-5 w-5 cursor-pointer"
                                        />
                                    </MenuButton>
                                    <transition
                                        enter-active-class="transition duration-100 ease-out"
                                        enter-from-class="transform scale-95 opacity-0"
                                        enter-to-class="transform scale-100 opacity-100"
                                        leave-active-class="transition duration-75 ease-in"
                                        leave-from-class="transform scale-100 opacity-100"
                                        leave-to-class="transform scale-95 opacity-0"
                                    >
                                        <MenuItems
                                            class="sm:absolute z-40 mt-1 origin-top-left divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        >
                                            <div class="px-1 py-1">
                                                <template
                                                    v-if="
                                                        $page.props.user
                                                            .email ==
                                                        'go.sedekah0711@gmail.com'
                                                    "
                                                >
                                                    <MenuItem
                                                        v-slot="{ active }"
                                                    >
                                                        <button
                                                            :class="[
                                                                active
                                                                    ? 'bg-indigo-500 text-white'
                                                                    : 'text-gray-900',
                                                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                            ]"
                                                            @click="$emit('approveAdmin', bData.id)"
                                                        >
                                                            Approve to admin
                                                        </button>
                                                    </MenuItem>
                                                </template>
                                                <MenuItem v-slot="{ active }">
                                                    <button
                                                        :class="[
                                                            active
                                                                ? 'bg-indigo-500 text-white'
                                                                : 'text-gray-900',
                                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                        ]"
                                                        @click="$emit('approveNeedy', bData.id)"
                                                    >
                                                        Approve to needy
                                                    </button>
                                                </MenuItem>
                                            </div>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                            </template>
                            <!-- needy actions -->
                            <template v-if="type == 'needy'">
                                <Menu>
                                    <MenuButton>
                                        <EllipsisVerticalIcon
                                            class="h-5 w-5 cursor-pointer"
                                        />
                                    </MenuButton>
                                    <transition
                                        enter-active-class="transition duration-100 ease-out"
                                        enter-from-class="transform scale-95 opacity-0"
                                        enter-to-class="transform scale-100 opacity-100"
                                        leave-active-class="transition duration-75 ease-in"
                                        leave-from-class="transform scale-100 opacity-100"
                                        leave-to-class="transform scale-95 opacity-0"
                                    >
                                        <MenuItems
                                            class="sm:absolute z-40 mt-1 origin-top-left divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        >
                                            <div class="px-1 py-1">
                                                <MenuItem v-slot="{ active }">
                                                    <button
                                                        :class="[
                                                            active
                                                                ? 'bg-indigo-500 text-white'
                                                                : 'text-gray-900',
                                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                        ]"
                                                        @click="$emit('removeNeedy', bData.id)"
                                                    >
                                                        Remove from needy
                                                    </button>
                                                </MenuItem>
                                            </div>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                            </template>
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
