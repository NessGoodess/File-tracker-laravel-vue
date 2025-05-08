<template>
    <div class="ag-grid-container">
        <div class="export-buttons">
            <button @click="exportToCSV">Exportar a CSV</button>
            <button @click="exportToPDF">Exportar a PDF</button>
        </div>
        <ag-grid-vue ref="agGrid" :rowData="data" :columnDefs="columns" :pagination="pagination"
            :paginationPageSize="paginationPageSize" :paginationPageSizeSelector="paginationPageSizeSelector"
            domLayout="autoHeight" class="ag-theme-alpine"
            @rowClicked="onRowClick" />
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { AgGridVue } from "ag-grid-vue3";
import { ClientSideRowModelModule, PaginationModule } from 'ag-grid-community';
import { ModuleRegistry, CsvExportModule } from "ag-grid-community";
import jsPDF from "jspdf";
import "jspdf-autotable"

ModuleRegistry.registerModules([ClientSideRowModelModule, PaginationModule]);
ModuleRegistry.registerModules([CsvExportModule]);

export default defineComponent({
    name: "DataTable",
    components: {
        AgGridVue,
    },
    props: {
        data: {
            type: Array,
            required: true,
        },
        columns: {
            type: Array,
            required: true,
        },
        pagination: {
            type: Boolean,
            default: true,
        },
        paginationPageSize: {
            type: Number,
            default: 10,
        },
        paginationPageSizeSelector: {
            type: Array,
            default: () => [5, 10, 20],
        },
    },
    mounted() {
        this.gridApi = this.$refs.agGrid.api;
    },
    methods: {
        onRowClick(event) {
            this.$emit("row-click", event.data.id);
        },
        formatDate(date) {
            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            return `${day}/${month}/${year}`;
        },

        exportToCSV() {
            const gridApi = this.$refs.agGrid.api;
            if (gridApi) {
                const csvData = gridApi.getDataAsCsv();
                const blob = new Blob([csvData], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const newTab = window.open(url, '_blank');

                if (!newTab) {
                    alert("El navegador bloqueó la apertura de la nueva pestaña. Asegúrate de permitir ventanas emergentes.");
                }
            } else {
                alert("No se pudo exportar a CSV.");
            }
        },

        exportToPDF() {
            const doc = new jsPDF();

            const data = this.data.map(item => {
                return this.columns.map(col => {
                    if (col.field === 'category.name') {
                        return item.category?.name || 'N/A';
                    }
                    if (col.field === 'status.name') {
                        return item.status?.name || 'N/A';
                    }
                    if (col.field.includes('date') || col.headerName.includes('FECHA')) {
                        return this.formatDate(item[col.field]);
                    }
                    return item[col.field];
                });
            });

            const columnTitles = this.columns.map(col => col.headerName);

            doc.autoTable({
                head: [columnTitles],
                body: data,
                margin: { top: 10 },
                styles: { fontSize: 10 },
            });

            const pdfData = doc.output('bloburl');
            const newTab = window.open(pdfData, '_blank');
            if (newTab) {
                newTab.focus();
            } else {
                alert("El navegador bloqueó la descarga. Permite las ventanas emergentes.");
            }
        },
    },
});
</script>

<style scoped>
.ag-grid-container {
    width: 100%;
    max-width: 100%;
    min-height: 200px;
}

.export-buttons {
    margin-bottom: 20px;
}

.export-buttons button {
    margin-right: 10px;
}
</style>
