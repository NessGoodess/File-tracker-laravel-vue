<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'button',
    },
    href: {
        type: String,
        default: null,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const isLink = computed(() => !!props.href);
</script>

<template>
    <component :is="isLink ? 'a' : 'button'" :type="isLink ? null : type" :href="isLink ? href : null"
        :disabled="disabled"
        :class="['inline-flex items-center rounded-md border border-transparent px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900', {'bg-primary': true}]">
        <slot />
    </component>
</template>
