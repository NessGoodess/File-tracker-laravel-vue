<template>
    <div class="flex flex-col">
        <label class="text-sm font-semibold text-gray-700">{{ label }}</label>
        <p class="mt-1 px-3 py-2 bg-gray-50 rounded-md border">{{ content }}</p>
    </div>
</template>

<script setup>
defineProps({
    label: String,
    content: String
});
</script>
