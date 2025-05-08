// Function to export data to a CSV file
export const exportToCSV1 = () => {
    const rows = document.querySelectorAll('.results-table tr');
    let csvContent = "Nombre,Tipo,Descripcion,Estado,Fecha de Recepción,Fecha de Alta\n";

    rows.forEach((row, index) => {
        if (index === 0) return;
        const cells = row.querySelectorAll('th');
        const rowData = Array.from(cells).map(cell => cell.textContent.trim()).join(",");
        csvContent += rowData + "\n";
    });

    const hiddenLink = document.createElement('a');
    hiddenLink.href = 'data:text/csv;charset=utf-8,' + encodeURI(csvContent);
    hiddenLink.target = '_blank';
    hiddenLink.download = 'documentos.csv';
    hiddenLink.click();
}

export const exportToCSV = (tableData) => {
    console.log(tableData)
    if (!tableData || !Array.isArray(tableData)) {
        console.error("tableData is undefined or not an array.");
        return;
    }
    let csvContent = "Nombre,Tipo,Descripcion,Estado,Fecha de Recepción,Fecha de Alta\n";

    tableData.forEach((row) => {
        const title=row.title;
        const type=row.category.name;
        const description=row.description;
        const status=row.status.name;
        const received_date=row.received_date;
        const created_at=row.created_at;
      csvContent += `${title},${type},${description},${status},${received_date},${created_at}\n`;
    });

    const hiddenLink = document.createElement("a");
    hiddenLink.href = "data:text/csv;charset=utf-8," + encodeURI(csvContent);
    hiddenLink.target = "_blank";
    hiddenLink.download = "documentos.csv";
    hiddenLink.click();
  };

// Function to export data to a PDF file
export const exportToPDF = () => {

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const table = document.getElementById("results-table");
    const rows = table.querySelectorAll("tr");

    // Título del PDF
    doc.setFontSize(18);
    doc.text("Resultados de la Consulta de Documentos", 14, 20);

    // Agregar las cabeceras
    const headers = [];
    const headerCells = rows[0].querySelectorAll("th");
    headerCells.forEach(cell => {
        headers.push(cell.textContent.trim());
    });

    // Establecer la posición de inicio para las filas de la tabla
    let yPosition = 30;

    // Agregar cabeceras de tabla
    doc.autoTable({
        head: [headers],
        startY: yPosition,
        styles: {
            fontSize: 12,
            font: "helvetica",
            cellPadding: 3,
            halign: "center"
        },
    });

    // Recorrer y agregar las filas de la tabla
    const rowData = [];
    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].querySelectorAll("td");
        const row = [];
        cells.forEach(cell => {
            row.push(cell.textContent.trim());
        });
        rowData.push(row);
    }

    // Agregar las filas de datos al PDF
    doc.autoTable({
        body: rowData,
        startY: doc.lastAutoTable.finalY + 10,
        styles: {
            fontSize: 10,
            cellPadding: 3,
            halign: "center"
        }
    });

    // Guardar el PDF generado
    doc.save("documentos.pdf");
}
