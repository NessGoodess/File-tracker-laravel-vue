<script setup>
import { ref, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-alpine.css';
import { AgGridVue } from 'ag-grid-vue3';

const page = usePage();
const documents = ref(page.props.documents.data);
const currentStatus = ref(page.props.filters.status || null);

// Array de pestañas dinámico
const tabs = ref([
    { name: 'Todos', status: null },
    { name: 'Firmados', status: 'Firmado' },
    { name: 'Entregados', status: 'Entregado' },
    { name: 'En Proceso', status: 'En Proceso' }
]);

const columnDefs = ref([
    { field: 'id', headerName: 'ID', sortable: true, filter: true },
    { field: 'name', headerName: 'Nombre', sortable: true, filter: true },
    { field: 'status', headerName: 'Estado', sortable: true, filter: true }
]);

// Cambia la URL con Inertia según el estado seleccionado
const changeStatus = (status) => {
    currentStatus.value = status;
    router.get('/documents', { status }, { preserveState: true });
};

// Detecta cambios en los datos recibidos
watch(() => page.props.documents, (newDocs) => {
    documents.value = newDocs.data;
});
</script>

<template>
  <div>
    <!-- Generar pestañas dinámicamente -->
    <div class="tabs">
      <button
        v-for="tab in tabs"
        :key="tab.status"
        :class="{ active: currentStatus === tab.status }"
        @click="changeStatus(tab.status)">
        {{ tab.name }}
      </button>
    </div>

    <!-- AG Grid -->
    <ag-grid-vue
      class="ag-theme-alpine"
      style="width: 100%; height: 500px;"
      :rowData="documents"
      :columnDefs="columnDefs"
      pagination="true"
      paginationPageSize="10">
    </ag-grid-vue>
  </div>
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
