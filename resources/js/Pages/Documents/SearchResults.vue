<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Table.vue';
import { formatDate } from '@/Utils/dateFormater';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
const { documentsSearch, searchTerm, message } = usePage().props;

const documentsRef = ref(documentsSearch);
const searchTermRef = ref(searchTerm);
const messageRef = ref(message);

const showDocument = (id) => {
    router.visit(route('documents.show', id));
};

</script>

<template>

    <Head title="Search" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Busqueda
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="overflow-x-auto bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <h1>Resultados de la Búsqueda: "{{ searchTermRef }}"</h1>
                </div>
                <div v-if="messageRef" class="alert alert-warning overflow-x-auto bg-white p-4 shadow sm:rounded-lg sm:p-8">
                      {{ messageRef }}
                </div>

                <div v-if="documentsRef.length > 0" class="overflow-x-auto bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <Table>
                        <template #table-header>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha de Recepción
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha de Alta
                            </th>
                        </template>
                        <template #table-body>
                            <tr v-if="documentsRef.length === 0">
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay documentos disponibles.
                                </td>
                            </tr>
                            <tr v-for="document in documentsRef" :key="document.id" @click="showDocument(document.id)"
                                class="cursor-pointer hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ document.title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ document.category_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ document.status_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ formatDate(document.received_date) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ formatDate(document.created_at) }}
                                </td>
                            </tr>
                        </template>
                    </Table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
