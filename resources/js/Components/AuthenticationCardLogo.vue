<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
</script>

<template>
    <Link :href="'/'">
        <ApplicationMark />
    </Link>
</template>
