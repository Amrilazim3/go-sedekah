<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? "block pl-3 pr-4 py-2 border-l-4 border-indigo-700 text-base font-medium text-white bg-indigo-500 hover:bg-indigo-400 hover:border-indigo-600 focus:outline-none focus:bg-indigo-400 focus:border-indigo-600 transition"
        : "block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-400 hover:text-white hover:bg-indigo-500 hover:border-indigo-500 focus:outline-none focus:text-white focus:bg-indigo-500 focus:border-indigo-700 transition";
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" :class="classes" class="w-full text-left">
            <slot />
        </button>

        <Link v-else :href="href" :class="classes">
            <slot />
        </Link>
    </div>
</template>
