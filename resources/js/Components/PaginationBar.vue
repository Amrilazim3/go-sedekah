<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    links: Array,
});
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap justify-end mt-4 cursor-pointer">
            <template v-for="(link, key) in links" :key="key">
                <template v-if="link.url === null">
                    <div
                        class="mr-1 mb-1 px-4 py-3 text-sm cursor-not-allowed leading-4 text-gray-500 border rounded"
                        v-html="link.label"
                    />
                </template>
                <template v-else>
                    <Link
                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-indigo-200 focus:border-primary focus:text-primary"
                        :class="{ 'bg-indigo-500 text-white': link.active }"
                        :href="link.url"
                        preserve-scroll
                        v-html="link.label"
                    />
                </template>
            </template>
        </div>
    </div>
</template>
