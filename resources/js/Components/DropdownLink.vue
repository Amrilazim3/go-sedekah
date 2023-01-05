<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

const props = defineProps({
    href: String,
    as: String,
    linkActive: {
        type: Boolean,
        default: false
    }
});

const linkClasses = computed(() => {
    return props.linkActive
        ? 'block px-4 py-2 text-sm leading-5 bg-indigo-500 text-white hover:text-gray-700 hover:bg-indigo-400 focus:outline-none focus:bg-indigo-400 transition'
        : 'block px-4 py-2 text-sm leading-5 text-gray-400 hover:text-white hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500 transition';
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" type="submit" class="block w-full px-4 py-2 text-sm leading-5 text-gray-400 text-left hover:text-white hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500 transition">
            <slot />
        </button>

        <a v-else-if="as =='a'" :href="href" class="block px-4 py-2 text-sm leading-5 text-gray-400 hover:text-white hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500 transition">
            <slot />
        </a>

        <Link v-else :href="href" :class="linkClasses">
            <slot />
        </Link>
    </div>
</template>
