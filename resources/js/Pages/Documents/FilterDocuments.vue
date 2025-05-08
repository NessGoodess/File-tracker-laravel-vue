<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SelectInput from '@/Components/SelectInput.vue';
import DateInput from '@/Components/DateInput.vue';
import Table from '@/Components/Table.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import IconExcel from '@/Components/Icons/IconExcel.vue';
import IconPDF from '@/Components/Icons/IconPDF.vue';
import InputLabel from '@/Components/InputLabel.vue';

import { exportToCSV } from '@/Utils/PDFCreater';
import { formatDate } from '@/Utils/dateFormater';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const { categories, statuses, documents, filters } = usePage().props;
const categoriesRef = ref(categories);
const statusesRef = ref(statuses);
const documentsRef = ref(documents);

let docs = documentsRef;

const form = useForm({
    category: filters.category ?? '',
    status: filters.status ?? '',
    start_date: filters.start_date ?? '',
    end_date: filters.end_date ?? '',
});

const showDocument = (id) => {
    router.visit(route('documents.show', id));
};

const applyFilters = () => {
    form.post(route("documents.filters"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            documentsRef.value = page.props.documents;
            form.reset();
            docs = documentsRef.value
        },
        onError: (errors) => {
            console.error("Validation errors:", errors);
        },
    });
};


</script>

<template>

    <Head title="Queries" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Consultas Por Periodo
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="sm:rounded-lg sm:pt-2 sm:pb-2 sm:pl-8 sm:pr-8 bg-white shadow-md">
                    <form @submit.prevent="applyFilters()" class="grid grid-cols-5 gap-2 pt-2 pb-2 pl-4 pr-4">
                        <InputLabel for="category">Categoría</InputLabel>
                        <InputLabel for="status">Status</InputLabel>
                        <InputLabel for="start_date">Fecha Inicio</InputLabel>
                        <InputLabel for="end_date">Fecha Fin</InputLabel>
                        <div></div>
                        <SelectInput
                            id="category"
                            ref="categoryInput"
                            v-model="form.category"

                            class="mt-1 block w-full">
                            <option v-for="category in categoriesRef" :key="category.id" :value="String(category.id)">
                                {{ category.name }}
                            </option>
                        </SelectInput>
                        <SelectInput
                            id="status"
                            ref="statusInput"
                            v-model="form.status"
                            class="mt-1 block w-full">
                            <option v-for="status in statusesRef" :key="status.id" :value="String(status.id)">
                                {{ status.name }}
                            </option>
                        </SelectInput>
                        <DateInput
                            id="start_date"
                            ref="startDateInput"
                            v-model="form.start_date"
                            class="mt-1 block w-full" />
                        <DateInput
                            id="end_date"
                            ref="endDateInput"
                            v-model="form.end_date"
                            class="mt-1 block w-full" />

                        <div class=" flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Consultar</PrimaryButton>

                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-if="form.recentlySuccessful" class="text-sm text-green-600 bg-green-100 p-2">
                                    Exito!!
                                </p>
                            </Transition>
                        </div>
                    </form>
                    <div class="grid grid-cols-5 gap-2 pt-2 pb-2 pl-4 pr-4">
                        <div class="flex items-center justify-center">
                            <button @click.prevent="exportToCSV(docs)">
                                <IconExcel class="block h-9 w-auto fill-current text-gray-800" />
                                <InputLabel for="end_date">Excel</InputLabel>
                            </button>
                        </div>

                        <div class="flex items-center justify-center">
                            <button @click.prevent="exportToCSV(docs)">
                                <IconPDF class="block h-9 w-auto fill-current text-gray-800" />
                                <InputLabel for="end_date">Exportar</InputLabel>
                            </button>
                        </div>
                    </div>
                </div>


                <div class="overflow-x-auto bg-white p-4 shadow sm:rounded-lg sm:p-8">
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
                                    {{ document.category.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ document.status.name }}
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
