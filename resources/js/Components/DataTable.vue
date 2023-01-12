<script setup>
import { EllipsisVerticalIcon } from "@heroicons/vue/20/solid";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";

defineProps({
    headerData: Array,
    bodyData: Object || Array,
    type: String,
});

defineEmits(["removeAdmin", "approveAdmin", "approveNeedy", "removeNeedy"]);
</script>

<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="border-b">
                            <tr>
                                <template
                                    v-for="hData in headerData"
                                    :key="hData"
                                >
                                    <th
                                        scope="col"
                                        class="text-sm font-semibold text-gray-700 bg-gray-100 px-6 py-4 text-left"
                                    >
                                        {{ hData }}
                                    </th>
                                </template>
                            </tr>
                        </thead>
                        <template v-if="bodyData.length > 0">
                            <tbody>
                                <template
                                    v-for="bData in bodyData"
                                    :key="bData.id"
                                >
                                    <template v-if="route().current('admin.users.index')">
                                        <tr class="bg-white border-b">
                                            <td
                                                class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                            >
                                                {{ bData.name }}
                                            </td>
                                            <td
                                                class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                            >
                                                {{ bData.email }}
                                            </td>
                                            <td
                                                class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                            >
                                                <!-- admin actions -->
                                                <template
                                                    v-if="
                                                        type == 'admin' &&
                                                        $page.props.user.email ==
                                                            'go.sedekah0711@gmail.com' &&
                                                        bData.email !=
                                                            'go.sedekah0711@gmail.com'
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
                                                                class="md:absolute z-40 mt-1 origin-top-left divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                            >
                                                                <div
                                                                    class="px-1 py-1"
                                                                >
                                                                    <MenuItem
                                                                        v-slot="{
                                                                            active,
                                                                        }"
                                                                    >
                                                                        <button
                                                                            :class="[
                                                                                active
                                                                                    ? 'bg-indigo-500 text-white'
                                                                                    : 'text-gray-900',
                                                                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                                            ]"
                                                                            @click="
                                                                                $emit(
                                                                                    'removeAdmin',
                                                                                    bData.id
                                                                                )
                                                                            "
                                                                        >
                                                                            Remove
                                                                            from
                                                                            admin
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
                                                                class="md:absolute z-40 mt-1 origin-top-left divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                            >
                                                                <div
                                                                    class="px-1 py-1"
                                                                >
                                                                    <template
                                                                        v-if="
                                                                            $page
                                                                                .props
                                                                                .user
                                                                                .email ==
                                                                            'go.sedekah0711@gmail.com'
                                                                        "
                                                                    >
                                                                        <MenuItem
                                                                            v-slot="{
                                                                                active,
                                                                            }"
                                                                        >
                                                                            <button
                                                                                :class="[
                                                                                    active
                                                                                        ? 'bg-indigo-500 text-white'
                                                                                        : 'text-gray-900',
                                                                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                                                ]"
                                                                                @click="
                                                                                    $emit(
                                                                                        'approveAdmin',
                                                                                        bData.id
                                                                                    )
                                                                                "
                                                                            >
                                                                                Approve
                                                                                to
                                                                                admin
                                                                            </button>
                                                                        </MenuItem>
                                                                    </template>
                                                                    <MenuItem
                                                                        v-slot="{
                                                                            active,
                                                                        }"
                                                                    >
                                                                        <button
                                                                            :class="[
                                                                                active
                                                                                    ? 'bg-indigo-500 text-white'
                                                                                    : 'text-gray-900',
                                                                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                                            ]"
                                                                            @click="
                                                                                $emit(
                                                                                    'approveNeedy',
                                                                                    bData.id
                                                                                )
                                                                            "
                                                                        >
                                                                            Approve
                                                                            to needy
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
                                                                class="md:absolute z-40 mt-1 origin-top-left divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                            >
                                                                <div
                                                                    class="px-1 py-1"
                                                                >
                                                                    <MenuItem
                                                                        v-slot="{
                                                                            active,
                                                                        }"
                                                                    >
                                                                        <button
                                                                            :class="[
                                                                                active
                                                                                    ? 'bg-indigo-500 text-white'
                                                                                    : 'text-gray-900',
                                                                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                                            ]"
                                                                            @click="
                                                                                $emit(
                                                                                    'removeNeedy',
                                                                                    bData.id
                                                                                )
                                                                            "
                                                                        >
                                                                            Remove
                                                                            from
                                                                            needy
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
                                </template>
                            </tbody>
                        </template>
                        <template v-else>
                            <h3 class="mt-2 text-md px-2">No result</h3>
                        </template>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
