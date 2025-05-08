<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed } from 'vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import DataTable from '@/Components/DataTable.vue';

const page = usePage();
const currentStatus = ref(page.props.filters.status || null);

const tabs = computed(() => [
    { name: 'Todos', status: null },
    ...page.props.statuses.map(s => ({ name: s.name, status: s.name }))
]);

const columns = ref([
    { field: 'id', headerName: 'ID', sortable: true, filter: true },
    { field: 'title', headerName: 'Título', sortable: true, filter: true },
    { field: 'status.name', headerName: 'Estado', sortable: true, filter: true }
]);

const documents = computed(() => page.props.documents.data);

const changeStatus = (status) => {
    currentStatus.value = status;
    router.get('/documents', { status }, { preserveState: true });
};
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
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div>
                    <!-- Pestañas dinámicas -->
                    <div class="tabs">
                        <button
                            v-for="tab in tabs"
                            :key="tab.status"
                            :class="{ active: currentStatus === tab.status }"
                            @click="changeStatus(tab.status)">
                            {{ tab.name }}
                        </button>
                    </div>

                    <!-- DataTable reutilizable -->
                    <DataTable
                        :data="documents"
                        :columns="columns"
                        :pagination="true"
                        :paginationPageSize="10"
                        :paginationPageSizeSelector="[5, 10, 20]"
                        @row-click="(id) => console.log('Fila clickeada con ID:', id)"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}
button {
    padding: 10px 15px;
    border: none;
    cursor: pointer;
    background: #ddd;
    border-radius: 5px;
}
button.active {
    background: #007bff;
    color: white;
}
</style>
