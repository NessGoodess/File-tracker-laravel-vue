<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'flex w-full items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-white-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'flex w-full items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-100 hover:text-gray-00 hover:border-gray-300 focus:outline-none focus:text-gray-500 focus:border-gray-300 transition duration-150 ease-in-out',
);

</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
