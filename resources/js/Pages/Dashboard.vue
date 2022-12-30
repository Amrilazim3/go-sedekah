<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-2 overflow-hidden shadow-xl sm:rounded-lg">
                    <h2>Hye, {{ $page.props.inertia.user.roles[0] }}</h2>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
