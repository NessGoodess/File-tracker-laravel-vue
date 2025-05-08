<template>
    <section class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
        <header class="border-b pb-4 mb-6">
            <h2 class="text-xl font-bold text-gray-900">Información del Registro</h2>
            <p class="text-sm text-gray-500">Se muestran datos de todo el registro</p>
        </header>

        <!-- Layout Principal -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Sección Izquierda (Datos Principales) -->
            <div class="md:col-span-2 space-y-6">
                <div v-for="(value, key) in mainFields" :key="key">
                    <Label :for="key" :value="value.label" class="font-semibold text-gray-700" />
                    <p :id="key" class="mt-1 px-3 py-2 bg-gray-50 rounded-md border">{{ value.content }}</p>
                </div>
            </div>

            <!-- Panel Derecho (Fechas y Metadatos) -->
            <div class="bg-gray-100 p-4 rounded-lg shadow-sm border-l md:pl-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Detalles del Registro</h3>
                <div class="space-y-4">
                    <div v-for="(value, key) in dateFields" :key="key">
                        <Label :for="key" :value="value.label" class="text-gray-600 text-sm" />
                        <p :id="key" class="mt-1 px-3 py-2 bg-white rounded-md border">{{ value.content }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
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

// Campos principales (Sección Izquierda)
const mainFields = computed(() => ({
    title: { label: 'Título del Documento', content: document.title },
    reference_number: { label: 'Número de Referencia', content: document.reference_number || 'Sin número' },
    category: { label: 'Tipo', content: document.category.name },
    status: { label: 'Estado', content: document.status.name },
    department: { label: 'Departamento', content: document.department ? document.department.name : 'Sin especificar' },
    destination_department: { label: 'Departamento de Destino', content: document.destination_department ? document.destination_department.name : 'Sin especificar' },
    description: { label: 'Descripción', content: document.description || 'Sin descripción' },
    created_by: { label: 'Creado por', content: document.user ? document.user.name : 'Usuario Eliminado' },
}));

// Campos de fechas (Panel Derecho)
const dateFields = computed(() => ({
    issued_date: { label: 'Fecha de Emisión', content: formatDateEs(document.issue_date) },
    received_date: { label: 'Recibido el', content: formatDateEs(document.received_date) },
    created_at: { label: 'Subido al Sistema el', content: formatDateEs(document.created_at) },
    updated_at: { label: 'Última Actualización', content: formatDateEs(document.updated_at) },
}));
</script>
