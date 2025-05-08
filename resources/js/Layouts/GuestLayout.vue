<!--
<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
-->

<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen flex-row items-center pt-6 sm:justify-center sm:pt-0">
        <div class="flex justify-center items-center p-4 rounded-lg w-1/4 h-1/4 hidden lg:block">
            <Link href="/">
            <ApplicationLogo class="h-full w-full fill-current text-gray-500" />
            </Link>
        </div>

        <div class="mt-6 w-full overflow-hidden bg-gray-100 px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
