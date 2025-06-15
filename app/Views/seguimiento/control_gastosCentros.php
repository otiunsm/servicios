<!-- JavaScript para manejar la selección del clasificador -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery y DataTables JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Control de Gastos</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>" class="text-muted">Panel de Control</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card Header-->
            <div class="card card-custom mb-4">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Clasificadores
                            <select id="clasificadores" name="clasificadores" class="selectpicker form-control" title="Elige el clasificador...">
                                <?php foreach ($clasificadores as $clasificador): ?>
                                    <option value="<?= esc($clasificador['id_clasificador']) ?>"
                                        data-nombre="<?= esc($clasificador['nombre_clasificador']) ?>">
                                        <?= esc($clasificador['nombre_clasificador']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </h3>
                    </div>
                </div>
            </div>
            <!--end::Card Header-->
            <div id="contenidoPantalla" style="display: none;">

                <!--begin::Card Body-->
                <div class="card card-custom mb-4" id="captura" name="captura">
                    <div class="card-body">
                        <!-- Botones de exportación -->
                        <div class="text-center mb-3">
                            <button onclick="exportToExcel()" class="btn btn-success">Exportar a Excel</button>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group d-flex flex-column align-items-center">
                                    <h10 class="mr-3 mb-0">Programa:</h10>
                                    <input type="text" class="form-control" name="codPrograma" value="<?= esc($programaNombre) ?>" style="width: 250px;" readonly />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group d-flex flex-column align-items-center">
                                    <h10 class="mr-3 mb-0">Fuente de Financiamiento:</h10>
                                    <input type="text" class="form-control" name="codFuente" value="<?= esc($fuenteNombre) ?>" style="width: 250px;" readonly />
                                </div>
                                <div class="form-group d-flex flex-column align-items-center">
                                    <h10 class="mr-3 mb-0">PIA:</h10>
                                    <input type="text" class="form-control" name="pia" style="width: 120px;" readonly />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group d-flex flex-column align-items-center">
                                    <h10 class="mr-3 mb-0">Meta:</h10>
                                    <input type="text" class="form-control" name="nomMeta" value="<?= esc($metaNombre) ?>" style="width: 250px;" readonly />
                                </div>
                                <div class="form-group d-flex flex-column align-items-center">
                                    <h10 class="mr-3 mb-0">PIM - INICIAL:</h10>
                                <input type="text" class="form-control" name="pim" style="width: 120px;" readonly />

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group d-flex flex-column align-items-center">
                                    <h10 class="mr-3 mb-0">Proyecto/Actividad:</h10>
                                    <input type="text" class="form-control" name="clasificadorNombre" style="width: 250px;" readonly />
                                </div>
                            </div>
                        </div>

                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2">N°</th>
                                    <th rowspan="2">Fecha de<br>Ingreso</th>
                                    <th rowspan="2">Detalle</th>
                                    <th rowspan="2">Modificación</th>
                                    <th rowspan="2">PIM</th>
                                    <th colspan="3">CERTIFICACIÓN</th>
                                    <th rowspan="2">Saldo</th>
                                </tr>
                                <tr class="text-center">
                                    <th>Monto</th>
                                    <th>Rebaja</th>
                                    <th>Ampliación</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card Body-->
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>

<script>
    function exportToExcel() {
        // Obtener los valores de los campos adicionales
        const programa = document.getElementsByName("codPrograma")[0]?.value || "";
        const fuente = document.getElementsByName("codFuente")[0]?.value || "";
        const meta = document.getElementsByName("nomMeta")[0]?.value || "";
        const clasificador = document.getElementsByName("clasificadorNombre")[0]?.value || "";
        const pia = document.getElementsByName("pia")[0]?.value || "";
        const pim = document.getElementsByName("pim")[0]?.value || "";

        // Preparar los datos para la hoja de Excel
        const data = [
            ['Fuente de Financiamiento', programa],
            ['Meta', meta],
            ['Proyecto / Actividad', clasificador],
            ['PIA', pia],
            ['PIM', pim],
            [],
            ['N° Certificación', 'Fecha de Ingreso', 'Detalle', 'Modificación', 'PIM', 'Monto', 'Rebaja', 'Ampliación', 'Saldo']
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



    $(document).ready(function() {
        $('#clasificadores').change(function() {
            const clasificadorId = $(this).val();
            if (!clasificadorId) return;

            // Obtiene el nombre del clasificador seleccionado desde el atributo data-nombre
            const clasificadorNombre = $(this).find('option:selected').data('nombre');

            // Asigna el nombre al campo correspondiente en la vista
            $('input[name="clasificadorNombre"]').val(clasificadorNombre);
            //---------------

            // Aquí están los datos de programa, fuente, y meta que vienen de la otra pantalla
            const categoriaId = '<?= $id_categoria ?>';
            const programaId = '<?= $id_programa ?>';
            const fuenteId = '<?= $id_fuente ?>';
            const metaId = '<?= $id_meta ?>';
            const id_centro_costos = '<?= $id_centro_costos ?>';

            $('input[name="id_categoria"]').val(categoriaId);
            $('input[name="id_programa"]').val(programaId);
            $('input[name="id_fuente"]').val(fuenteId);
            $('input[name="id_meta"]').val(metaId);
            $('input[name="id_clasificador"]').val(clasificadorId);
            $('input[name="id_centro_costos"]').val(id_centro_costos);

            // Oculta el contenido antes de realizar la verificación
            $('#contenidoPantalla').show();

            $.post("<?= base_url('SegDesglose/verificarPIAClasificador') ?>", {
                id_categoria: categoriaId,
                id_programa: programaId,
                id_fuente: fuenteId,
                id_meta: metaId,
                id_clasificador: clasificadorId,
                id_centro_costos: id_centro_costos
            }, function(response) {
                if (response.error) {
                    alert(response.error);
                    return;
                }

                // Asignar el valor del PIA al input correspondiente
                $('input[name="pia"]').val(response.pia || '');

                // Asignar el valor del PIM al input correspondiente
                $('input[name="pim"]').val(response.pim || '');

            });

            /////////////////
            $.post("<?= base_url('SegDesglose/obtenerCertificados') ?>", {
                id_categoria: categoriaId,
                id_programa: programaId,
                id_fuente: fuenteId,
                id_meta: metaId,
                id_clasificador: clasificadorId,
                id_centro_costos: id_centro_costos
            }, function(response) {
                // Limpia la tabla antes de llenarla con nuevos datos
                $('#kt_datatable tbody').empty();

                let previousPIM = parseFloat(document.getElementsByName("pim")[0]?.value || "");
                let previousSaldo = parseFloat(document.getElementsByName("pim")[0]?.value || "");
                let PIM_acumulado = 0; // Para almacenar el último valor de PIM
                let certificado_acumulado = 0; // Para almacenar la resta del último PIM - Saldo

                response.forEach((certificado, index) => {
                    let PIM, Saldo;

                    // Asegurarse de que los valores numéricos se traten como números
                    let modificacion = parseFloat(certificado.modificacion) || 0;
                    let monto = parseFloat(certificado.certificacion_monto) || 0;
                    let rebaja = parseFloat(certificado.certificacion_rebaja) || 0;
                    let ampliacion = parseFloat(certificado.certificacion_ampliacion) || 0;

                    // Para las filas posteriores, PIM se calcula sumando la modificación con el PIM anterior
                    PIM = previousPIM + modificacion;

                    // El saldo se calcula sumando el saldo anterior + la modificación - (monto + rebaja - ampliacion)
                    Saldo = previousSaldo + modificacion - monto + (rebaja - ampliacion);

                    // Actualiza las variables para la siguiente iteración
                    previousPIM = PIM;
                    previousSaldo = Saldo;

                    // Asignar el último valor de PIM y calcular certificado_acumulado
                    if (index === response.length - 1) {
                        PIM_acumulado = PIM;
                        certificado_acumulado = PIM - Saldo;
                    }

                    // Inserta la fila en la tabla
                    $('#kt_datatable tbody').append(`
            <tr class="text-center">
                <td>${certificado.codigo_transaccion || ""}</td>
                <td>${certificado.fecha}</td>
                <td>${certificado.detalle}</td>
                <td>${modificacion}</td> 
                <td>${PIM}</td> 
                <td>${monto}</td>
                <td>${rebaja}</td>
                <td>${ampliacion}</td>
                <td>${Saldo}</td>
            </tr>
        `);
                });


            }).fail(function() {
                alert("Error al cargar los datos de certificados");
            });

        });

    });
</script>