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
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="text-center">Operaciones</h4>
                                <div class="text-center align-items-center">
                                    <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#formcertificado">
                                        <i class="fas fa-plus"></i> Certificado
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#formnota">
                                        <i class="fas fa-plus"></i> Nota Modificatoria
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    <th rowspan="2">Acciones</th>
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

<!-- Modal Certificado-->
<div class="modal fade" id="formcertificado" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Certificado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="form_prog">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="id_categoria">
                            <input type="hidden" name="id_programa">
                            <input type="hidden" name="id_fuente">
                            <input type="hidden" name="id_meta">
                            <input type="hidden" name="id_clasificador">
                            <input type="hidden" name="id_certificado">
                            <input type="hidden" name="mode" value="create">

                            <div class="form-group">
                                <label>N° Certificado <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="certificado" placeholder="Ingresar código de certificado" required />
                            </div>
                            <div class="form-group">
                                <label>Centro de Costo (Opcional)</label>
                                <select class="selectpicker form-control" data-live-search="true" id="idCentro" name="idCentros" title="Elije centro de costo">
                                    <?php foreach ($SegCentrocostos as $centrocosto): ?>
                                        <option value="<?= $centrocosto['idCentro'] ?>"><?= esc($centrocosto['nombrecen']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Detalle<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="detalle" rows="2" placeholder="Ingresar detalle" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Certificación<span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipo_certificacion" value="monto" required /> Monto
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipo_certificacion" value="rebaja" required /> Rebaja
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipo_certificacion" value="ampliacion" required /> Ampliación
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="dinero" placeholder="Ingresar valor" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitButton2" class="btn btn-success font-weight-bold">Guardar</button>
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nota Modificatoria-->
<div class="modal fade" id="formnota" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nota Modificatoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>

            <form id="form_nota_modificatoria">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="id_categoria">
                            <input type="hidden" name="id_programa">
                            <input type="hidden" name="id_fuente">
                            <input type="hidden" name="id_meta">
                            <input type="hidden" name="id_clasificador">
                            <input type="hidden" name="id_certificado">
                            <input type="hidden" name="mode" value="create">

                            <div class="form-group">
                                <label>Centro de Costo (Opcional)</label>
                                <select class="selectpicker form-control" data-live-search="true" id="idCentro" name="idCentritos" title="Elije centro de costo" >
                                    <?php foreach ($SegCentrocostos as $centrocosto): ?>
                                        <option value="<?= $centrocosto['idCentro'] ?>"><?= esc($centrocosto['nombrecen']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Detalle<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="detalle1" rows="2" placeholder="Ingresar detalle" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Monto<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="notadinero" placeholder="Ingresar monto de modificación" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitButtonNota" class="btn btn-success font-weight-bold">Guardar</button>
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal para ingreso de PIA -->
<div class="modal fade" id="piaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresar PIA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="piaForm" method="post" action="<?= base_url('SegCarpetas/actualizarPIA') ?>">
                    <input type="hidden" id="inputDetalle" name="id_detalle">
                    <input type="number" id="inputPIA" name="pia" class="form-control" placeholder="Ingrese el valor de PIA" required>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="piaForm" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" id="cancelButton" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
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

            // Aquí están los datos de programa, fuente, y meta que vienen de la otra pantalla
            const categoriaId = '<?= $id_categoria ?>';
            const programaId = '<?= $id_programa ?>';
            const fuenteId = '<?= $id_fuente ?>';
            const metaId = '<?= $id_meta ?>';

            $('input[name="id_categoria"]').val(categoriaId);
            $('input[name="id_programa"]').val(programaId);
            $('input[name="id_fuente"]').val(fuenteId);
            $('input[name="id_meta"]').val(metaId);
            $('input[name="id_clasificador"]').val(clasificadorId);

            // Oculta el contenido antes de realizar la verificación
            $('#contenidoPantalla').hide();

            // Consulta al servidor para verificar el PIA del clasificador seleccionado
            $.post("<?= base_url('SegCarpetas/verificarPIAClasificador') ?>", {
                id_categoria: categoriaId,
                id_programa: programaId,
                id_fuente: fuenteId,
                id_meta: metaId,
                id_clasificador: clasificadorId
            }, function(response) {
                if (response.error) {
                    alert(response.error);
                    return;
                }

                // Asignar el valor del PIA al input correspondiente
                $('input[name="pia"]').val(response.pia || '');

                // Asignar el valor del PIM al input correspondiente
                $('input[name="pim"]').val(response.pim || '');

                // Verificar si el PIA está vacío (0 o NULL) y mostrar el modal
                if (!response.pia || response.pia == 0) {
                    // Si el PIA es 0 o NULL, abre el modal
                    $('#inputDetalle').val(response.id_detalle);
                    $('#piaModal').modal('show');
                } else {
                    // Si el PIA tiene un valor válido, muestra el contenido
                    $('#contenidoPantalla').show();
                }
            });

            /////////////////
            $.post("<?= base_url('SegCarpetas/obtenerCertificados') ?>", {
                id_categoria: categoriaId,
                id_programa: programaId,
                id_fuente: fuenteId,
                id_meta: metaId,
                id_clasificador: clasificadorId
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
                <td>
                    <button class="btn btn-sm" onclick="editarCertificado(${certificado.id_certificado}, '${certificado.codigo_transaccion}', '${certificado.detalle || ""}', ${modificacion}, ${monto}, ${rebaja}, ${ampliacion})">
                        <i class="fas fa-edit text-success"></i>
                    </button>
                    <button class="btn btn-sm" onclick="eliminarCertificado(${certificado.id_certificado})">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </button>
                </td>
            </tr>
        `);
                });

                // Actualizar los valores en la base de datos
                $.ajax({
                    url: "<?= base_url('SegCarpetas/guardarAcumulados') ?>",
                    type: "POST",
                    data: {
                        id_categoria: categoriaId,
                        id_programa: programaId,
                        id_fuente: fuenteId,
                        id_meta: metaId,
                        id_clasificador: clasificadorId,
                        PIM_acumulado: previousPIM, // Último PIM calculado
                        certificado_acumulado: previousPIM - previousSaldo // Certificado acumulado calculado
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response.message); // Muestra el mensaje de éxito en la consola
                        } else {
                            alert(response.message); // Muestra el mensaje de error
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", error);
                    }
                });

            }).fail(function() {
                alert("Error al cargar los datos de certificados");
            });

        });

        // Limpiar la selección del clasificador si se cancela o no se ingresa PIA
        $('#cancelButton').click(function() {
            $('#clasificadores').val('').selectpicker('refresh');
        });

        $('#piaModal').on('hidden.bs.modal', function() {
            const piaValue = $('#inputPIA').val();
            if (!piaValue) {
                // Si no se ingresó un valor de PIA, limpiar la selección del clasificador
                $('#clasificadores').val('').selectpicker('refresh');
            }
        });
    });


    /////////--------
    //////////
    $('#form_prog').submit(function(event) {
        event.preventDefault();

        const mode = $('input[name="mode"]').val();
        const url = mode === 'create' ?
            "<?= base_url('SegCarpetas/guardarCertificado') ?>" :
            "<?= base_url('SegCarpetas/editarCertificado') ?>";

        const formData = {
            id_categoria: $('input[name="id_categoria"]').val(),
            id_programa: $('input[name="id_programa"]').val(),
            id_fuente: $('input[name="id_fuente"]').val(),
            id_meta: $('input[name="id_meta"]').val(),
            id_clasificador: $('input[name="id_clasificador"]').val(),
            certificado: $('input[name="certificado"]').val(),
            detalle: $('textarea[name="detalle"]').val(),
            tipo_certificacion: $('input[name="tipo_certificacion"]:checked').val(),
            dinero: $('input[name="dinero"]').val(),
            id_certificado: $('input[name="id_certificado"]').val(),
            idCentro: $('select[name="idCentros"]').val()
        };

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: mode === 'create' ? "Certificado Creado" : "Certificado Editado",
                        text: response.message || "La operación se realizó con éxito.",
                        icon: "success",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        location.reload(); // Recargar la página
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response.message || "Ocurrió un error al realizar la operación.",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: "Error",
                    text: "Ocurrió un error inesperado: " + error,
                    icon: "error",
                    confirmButtonText: "Aceptar"
                });
            }
        });
    });


    $('#form_nota_modificatoria').submit(function(e) {
        e.preventDefault();

        const mode = $('input[name="mode"]').val();
        const url = mode === 'create' ?
            "<?= base_url('SegCarpetas/guardarNotaModificatoria') ?>" :
            "<?= base_url('SegCarpetas/editarNotaModificatoria') ?>";

        const formData = {
            id_categoria: $('input[name="id_categoria"]').val(),
            id_programa: $('input[name="id_programa"]').val(),
            id_fuente: $('input[name="id_fuente"]').val(),
            id_meta: $('input[name="id_meta"]').val(),
            id_clasificador: $('input[name="id_clasificador"]').val(),
            detalle1: $('textarea[name="detalle1"]').val(),
            notadinero: $('input[name="notadinero"]').val(),
            id_certificado: $('input[name="id_certificado"]').val(),
            idCentro: $('select[name="idCentritos"]').val() || null
        };
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: mode === 'create' ? "Nota Modificatoria Creada" : "Nota Modificatoria Editada",
                        text: response.message || "La operación se realizó con éxito.",
                        icon: "success",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        $('#formnota').modal('hide'); // Cerrar el modal
                        location.reload(); // Recargar la página
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response.message || "Ocurrió un error al realizar la operación.",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: "Error",
                    text: "Ocurrió un error inesperado: " + error,
                    icon: "error",
                    confirmButtonText: "Aceptar"
                });
            }
        });
    });
</script>
<script>
    // Función para eliminar certificación
    function eliminarCertificado(idCertificado) {
        Swal.fire({
            title: "¿Estás seguro de eliminar este registro?",
            text: "Esta acción no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true,
            showLoaderOnConfirm: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= base_url('SegCarpetas/eliminarCertificacion') ?>", {
                        id_certificado: idCertificado
                    },
                    function(response) {
                        if (response.success) {
                            Swal.fire("Eliminado", response.Mensaje, "success").then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Error", response.Mensaje, "error");
                        }
                    }, 'json'
                );
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire("Cancelado", "La eliminación fue cancelada.", "error");
            }
        });

    }

    // Función para editar certificación
    function editarCertificado(idCertificado, codigo_transaccion, detalle, modificacion, monto, rebaja, ampliacion) {
        if (modificacion != 0) {
            // Modo de edición para Nota Modificatoria
            $('#formnota').modal('show');
            $('input[name="mode"]').val('edit'); // Cambia a modo edición
            $('textarea[name="detalle1"]').val(detalle || ''); // Llena el detalle
            $('input[name="notadinero"]').val(modificacion || ''); // Llena el monto de modificación
            $('input[name="id_certificado"]').val(idCertificado); // Llena el ID del certificado
        } else {
            // Modo de edición para Certificado
            $('#formcertificado').modal('show');
            $('input[name="mode"]').val('edit'); // Cambia a modo edición
            $('input[name="certificado"]').val(codigo_transaccion || ''); // Llena el código de certificado
            $('textarea[name="detalle"]').val(detalle || ''); // Llena el detalle
            $('input[name="dinero"]').val(monto || rebaja || ampliacion || ''); // Llena el monto, rebaja o ampliación
            $('input[name="tipo_certificacion"]')
                .filter([value = "${monto ? 'monto' : rebaja ? 'rebaja' : 'ampliacion'}"])
                .prop('checked', true); // Marca el tipo de certificación
            $('input[name="id_certificado"]').val(idCertificado); // Llena el ID del certificado
        }
    }
</script>