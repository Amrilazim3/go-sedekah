<script setup>
defineProps({
    placeholder: String,
    modelValue: String,
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <div class="relative rounded-md py-2 sm:py-4">
        <input
            type="search"
            class="form-input py-2 pl-10 block w-full leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:border-indigo-300 focus:shadow-outline-blue sm:text-sm sm:leading-5"
            :placeholder="placeholder"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <div
            class="absolute top-0 left-0 flex items-center h-full px-4 pointer-events-none"
        >
            <svg
                class="h-5 w-5 text-gray-400"
                viewBox="0 0 20 20"
                fill="currentColor"
            >
                <path
                    fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"
                ></path>
            </svg>
        </div>
    </div>
</template>
