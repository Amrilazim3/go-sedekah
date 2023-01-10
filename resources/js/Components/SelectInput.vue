<script setup>
defineProps({
    modelValue: String,
    data: Array,
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <select
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <template v-for="bank in data" :key="bank">
            <option :value="bank[0]">{{ bank[1] }}</option>
        </template>
    </select>
</template>
