<script setup>
import { ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const select = ref(null);

defineExpose({ focus: () => select.value.focus() });
</script>

<template>
    <select
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        v-model="model"
        ref="select"
    >
        <option value="" disabled>Seleccione una opción</option>
        <slot></slot>
    </select>
</template>

<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
