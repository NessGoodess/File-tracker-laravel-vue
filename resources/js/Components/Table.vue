<script setup>
</script>

<template>
    <table class="results-table min-w-full divide-y divide-gray-200 ">
        <thead class="bg-blue-100">
            <tr>
                <slot name="table-header" />
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <slot name="table-body" />
        </tbody>
    </table>
</template>
