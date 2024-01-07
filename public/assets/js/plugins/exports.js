function exportTableToExcel(tableId, fileNamePrefix) {
    var workbook = new ExcelJS.Workbook();
    var worksheet = workbook.addWorksheet('Datos');
    var table = document.getElementById(tableId);

    // Añadir encabezados a la hoja de cálculo
    var headerRow = worksheet.addRow([]);
    for (var i = 0; i < table.rows[0].cells.length - 1; i++) {
        headerRow.getCell(i + 1).value = table.rows[0].cells[i].textContent;
        headerRow.getCell(i + 1).font = { bold: true };
        headerRow.getCell(i + 1).alignment = { horizontal: 'center' };
    }

    // Añadir datos a la hoja de cálculo
    for (var i = 1; i < table.rows.length; i++) {
        var row = worksheet.addRow([]);
        for (var j = 0; j < table.rows[i].cells.length - 1; j++) {
            var cell = row.getCell(j + 1);
            cell.value = table.rows[i].cells[j].textContent;
            cell.alignment = { horizontal: 'left' };
            cell.border = { top: { style: 'thin' }, left: { style: 'thin' }, bottom: { style: 'thin' }, right: { style: 'thin' } };
        }
    }

    worksheet.columns.slice(0, -1).forEach((column) => {
        let maxWidth = 0;
        column.eachCell({ includeEmpty: false }, (cell) => {
            const len = cell.value ? String(cell.value).length : 10;
            if (len > maxWidth) {
                maxWidth = len;
            }
        });
        column.width = maxWidth + 2;
    });

    // Obtener la fecha actual y hora
    var currentDate = new Date();
    var formattedDate = currentDate.toLocaleDateString().replace(/\//g, '-'); // Formato MM-DD-YYYY
    var formattedTime = currentDate.toLocaleTimeString().replace(/:/g, '-'); // Formato HH-MM-SS

    // Nombre del archivo con fecha y hora
    var fileName = fileNamePrefix + '_' + formattedDate + '_' + formattedTime + '.xlsx';

    // Descargar el archivo
    workbook.xlsx.writeBuffer().then(function (buffer) {
        var blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        saveAs(blob, fileName);
    });
}

// Función para agregar evento si el elemento existe
function addEventIfElementExists(elementId, eventName, callback) {
    var element = document.getElementById(elementId);
    if (element) {
        element.addEventListener(eventName, callback);
    } else {
        console.error(`Element with ID '${elementId}' not found.`);
    }
}

// Uso de la función con una tabla específica
addEventIfElementExists('exportBtnUsers1', 'click', function () {
    exportTableToExcel('datatableUsers', 'Export_Usuarios');
});

addEventIfElementExists('exportBtnEstudiantes1', 'click', function () {
    exportTableToExcel('datatableEstudiantes', 'Export_Estudiantes');
});

addEventIfElementExists('exportBtnDocentes1', 'click', function () {
    exportTableToExcel('datatableDocentes', 'Export_Docentes');
});

addEventIfElementExists('exportBtnPersonal1', 'click', function () {
    exportTableToExcel('datatablePersonal', 'Export_Personal');
});

addEventIfElementExists('exportBtnMateriasHabilitados1', 'click', function () {
    exportTableToExcel('datatableMateriasHabilitados', 'Export_Materias_Activos');
});

addEventIfElementExists('exportBtnMaterias1', 'click', function () {
    exportTableToExcel('datatableMaterias', 'Export_Materias');
});

addEventIfElementExists('exportBtnPagos1', 'click', function () {
    exportTableToExcel('datatablePagos', 'Export_Pagos');
});

addEventIfElementExists('exportBtnReportMaterias', 'click', function () {
    exportTableToExcel('datatableReportMateria', 'Reporte_Materias');
});