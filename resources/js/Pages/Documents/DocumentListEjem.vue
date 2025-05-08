<script setup>
import { ref, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-alpine.css';
import { AgGridVue } from 'ag-grid-vue3';

const page = usePage();
const documents = ref(page.props.documents.data); // Datos iniciales
const currentStatus = ref(page.props.filters.status || null);
const columnDefs = ref([
    { field: 'id', headerName: 'ID', sortable: true, filter: true },
    { field: 'name', headerName: 'Nombre', sortable: true, filter: true },
    { field: 'status', headerName: 'Estado', sortable: true, filter: true }
]);

// Cambia la URL y recarga los datos con Inertia
const changeStatus = (status) => {
    currentStatus.value = status;
    router.get('/documents', { status }, { preserveState: true });
};

// Escucha cambios en `page.props.documents`
watch(() => page.props.documents, (newDocs) => {
    documents.value = newDocs.data;
});
</script>

<template>
  <div>
    <!-- Pestañas -->
    <div class="tabs">
      <button :class="{ active: !currentStatus }" @click="changeStatus(null)">Todos</button>
      <button :class="{ active: currentStatus === 'Firmado' }" @click="changeStatus('Firmado')">Firmados</button>
      <button :class="{ active: currentStatus === 'Entregado' }" @click="changeStatus('Entregado')">Entregados</button>
      <button :class="{ active: currentStatus === 'En Proceso' }" @click="changeStatus('En Proceso')">En Proceso</button>
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
