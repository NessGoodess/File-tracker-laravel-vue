<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTable from "@/Components/DataTable.vue";
import { formatDateEs } from '@/Utils/dateFormater';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
const { documents } = usePage().props;
const documentsRef = ref(documents);

const showDocument = (id) => {
    router.visit(route('documents.show', id));
};

const columns = ref([
    {
        field: "title",
        headerName: " TITULO",
        flex: 1},
    {
        field: "category.name",
        headerName: "TIPO",
        valueGetter: (params) => params.data?.category?.name || "N/A",
        flex: 1
    },
    {
        field: "status.name",
        headerName: "STATUS",
        valueGetter: (params) => params.data?.status?.name || "N/A",
        flex: 1
    },
    {
        field: "received_date",
        headerName: "FECHA DE RECEPCION",
        valueFormatter: (params) => formatDateEs(params.value),
        flex: 1
    },
    {
        field: "created_at",
        headerName: "FECHA DE ALTA",
        valueFormatter: (params) => formatDateEs(params.value),
        flex: 1
    },
]);

</script>

<template>
    <Head title="Documentos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Documentos
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <DataTable :data="documentsRef" :columns="columns" @row-click="showDocument" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
