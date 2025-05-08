<template>
    <section class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <header class="border-b pb-4 mb-6">
            <h2 class="text-xl font-bold text-gray-900">Información del Registro</h2>
            <p class="text-sm text-gray-500">Se muestran datos de todo el registro</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
            <div v-for="(value, key) in documentFields" :key="key" class="flex flex-col">
                <Label :for="key" :value="value.label" class="font-semibold text-gray-700" />
                <p :id="key" class="mt-1 px-3 py-2 bg-gray-50 rounded-md border">{{ value.content }}</p>
            </div>
        </div>

        <div class="mt-8 flex gap-4">
            <LinkButton :href="route('documents.edit', document.id)">
                Actualizar Registro
            </LinkButton>
            <DeleteDocumentForm class="max-w-xl" />
        </div>
    </section>
</template>

<script setup>
import Label from '@/Components/Label.vue';
import LinkButton from '@/Components/LinkButton.vue';
import DeleteDocumentForm from './DeleteDocument.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { formatDateEs } from '@/Utils/dateFormater';

const { document } = usePage().props;

const documentFields = computed(() => ({
    title: { label: 'Título del Documento', content: document.title },
    reference_number: { label: 'Número de Referencia', content: document.reference_number || 'Sin número' },
    category: { label: 'Tipo', content: document.category.name },
    status: { label: 'Estado', content: document.status.name },
    issued_date: { label: 'Fecha de Emisión', content: formatDateEs(document.issue_date) },
    received_date: { label: 'Recibido el', content: formatDateEs(document.received_date) },
    department: { label: 'Departamento', content: document.department ? document.department.name : 'Sin especificar' },
    destination_department: { label: 'Departamento de Destino', content: document.destination_department ? document.destination_department.name : 'Sin especificar' },
    created_at: { label: 'Subido al Sistema el', content: formatDateEs(document.created_at) },
    updated_at: { label: 'Última Actualización', content: formatDateEs(document.updated_at) },
    description: { label: 'Descripción', content: document.description || 'Sin descripción' },
    created_by: { label: 'Creado por', content: document.user ? document.user.name : 'Usuario Eliminado' },
}));
</script>
