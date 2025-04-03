<!-- JavaScript para manejar la selección del clasificador -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery y DataTables JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Resumen de Gastos</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom mb-4" id="captura" name="captura">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group d-flex flex-column align-items-center">
                                <h10 class="mr-3 mb-0">Fuente de Financiamiento:</h10>
                                <input type="text" class="form-control" name="codFuente" value="<?= esc($fuenteNombre) ?>" readonly/>
                            </div>
                        </div>
                        <div class="col-md-4">                                 
                            <div class="form-group d-flex flex-column align-items-center">
                                <h10 class="mr-3 mb-0">Proyecto/Actividad:</h10>
                                <input type="text" class="form-control" name="nomMeta" value="<?= esc($metaNombre) ?>" readonly/>
                            </div> 
                        </div>

                        <div class="col-md-4">
                            <div class="form-group d-flex flex-column align-items-center">
                                <h10 class="mr-3 mb-0">Meta:</h10>
                                <input type="text" class="form-control" name="codmeta" value="<?= esc($codigo_meta) ?>" readonly/>
                            </div>
                        </div>
                    </div>

                    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                        <thead>
                            <tr class="text-center">
                                <th>Detalle</th>
                                <th>PIA</th>
                                <th>PIM</th>
                                <th>Certificación</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clasificadores as $clasificador): ?>
                                <tr class="text-center">
                                    <td><?= esc($clasificador['detalle']) ?></td>
                                    <td><?= number_format($clasificador['PIA'], 2) ?></td>
                                    <td><?= number_format($clasificador['PIM'], 2) ?></td>
                                    <td><?= number_format($clasificador['certificacion'], 2) ?></td>
                                    <td><?= number_format($clasificador['saldo'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="text-center mb-10">
                        <button onclick="exportToExcel()" class="btn btn-success">Exportar a Excel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function exportToExcel() {
    // Obtener los valores de los campos adicionales
    const fuente = document.getElementsByName("codFuente")[0]?.value || "";
    const meta = document.getElementsByName("nomMeta")[0]?.value || "";
    const actividad = document.getElementsByName("codmeta")[0]?.value || "";

    // Preparar los datos para la hoja de Excel
    const data = [
        ['Fuente de Financiamiento', fuente],
        ['Meta', meta],
        ['Proyecto / Actividad', actividad],
        [],
        ['Descripción', 'PIA', 'PIM', 'Certificación', 'Saldo']
    ];

    // Obtener los datos de la tabla
    const table = document.getElementById("kt_datatable");
    const rows = table.querySelectorAll("tbody tr");
    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        const rowData = [];
        cells.forEach(cell => rowData.push(cell.innerText));
        data.push(rowData);
    });

    // Crear la hoja de Excel y agregar los datos
    const ws = XLSX.utils.aoa_to_sheet(data);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Control de Gastos");

    // Exportar el archivo Excel
    XLSX.writeFile(wb, "Control_de_Gastos.xlsx");
}
</script>