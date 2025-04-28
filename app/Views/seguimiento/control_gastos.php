<!-- JavaScript para manejar la selección del clasificador -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery y DataTables JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<!--begin::Content-->
<!-- Diseño mejorado del módulo Control de Gastos -->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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

  <div class="d-flex flex-column-fluid">
    <div class="container">
      <!-- Selector de Clasificadores -->
      <div class="card shadow-sm mb-4">
        <div class="card-header py-4">
          <h5 class="mb-0">Seleccionar Clasificador</h5>
        </div>
        <div class="card-body">
          <select id="clasificadores" name="clasificadores" class="selectpicker form-control" title="Elige el clasificador...">
            <?php foreach ($clasificadores as $clasificador): ?>
              <option value="<?= esc($clasificador['id_clasificador']) ?>"
                      data-nombre="<?= esc($clasificador['nombre_clasificador']) ?>">
                <?= esc($clasificador['nombre_clasificador']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div id="contenidoPantalla" style="display: none;">
        <!-- Sección Operaciones -->
        <div class="card shadow-sm mb-4">
          <div class="card-body text-center">
            <h5 class="font-weight-bold mb-3">Operaciones</h5>
            <button type="button" class="btn btn-outline-warning mx-2" data-toggle="modal" data-target="#formcertificado">
              <i class="fas fa-plus"></i> Certificado
            </button>
            <button type="button" class="btn btn-outline-primary mx-2" data-toggle="modal" data-target="#formnota">
              <i class="fas fa-plus"></i> Nota Modificatoria
            </button>
          </div>
        </div>

        <!-- Información General -->
        <div class="card shadow-sm mb-4">
          <div class="card-body">
            <div class="row">
              <?php
                $campos = [
                  ['Programa', 'codPrograma', $programaNombre],
                  ['Fuente de Financiamiento', 'codFuente', $fuenteNombre],
                  ['PIA', 'pia', ''],
                  ['Meta', 'nomMeta', $metaNombre],
                  ['PIM - INICIAL', 'pim', ''],
                  ['Proyecto/Actividad', 'clasificadorNombre', '']
                ];
                foreach ($campos as [$label, $name, $valor]) {
              ?>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                  <label class="font-weight-bold text-muted mb-1"><?= $label ?>:</label>
                  <input type="text" class="form-control text-center text-truncate w-100" name="<?= $name ?>" value="<?= esc($valor) ?>" readonly title="<?= esc($valor) ?>">
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

        <!-- Tabla de Certificaciones -->
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="mb-0">Detalle de Certificaciones</h5>
              <button onclick="exportToExcel()" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Exportar a Excel
              </button>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-hover text-center" id="kt_datatable">
                <thead class="thead-light">
                  <tr>
                    <th rowspan="2">N°</th>
                    <th rowspan="2">Fecha Ingreso</th>
                    <th rowspan="2">Detalle</th>
                    <th rowspan="2">Modificación</th>
                    <th rowspan="2">PIM</th>
                    <th colspan="3">CERTIFICACIÓN</th>
                    <th rowspan="2">Saldo</th>
                    <th rowspan="2">Acciones</th>
                  </tr>
                  <tr>
                    <th>Monto</th>
                    <th>Rebaja</th>
                    <th>Ampliación</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  @media (max-width: 768px) {
    .table-responsive {
      overflow-x: auto;
    }
  }
  .form-control[readonly] {
    background-color: #f9f9f9;
  }
</style>


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
                                <select class="selectpicker form-control" data-live-search="true" id="idCentro" name="idCentritos" title="Elije centro de costo">
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
                id_clasificador: clasificadorId,
            }, function(response) {
                // Limpia la tabla antes de llenarla con nuevos datos

                const table = $('#kt_datatable').DataTable();
                table.clear();

                let previousPIM = parseFloat(document.getElementsByName("pim")[0]?.value || "");
                let previousSaldo = parseFloat(document.getElementsByName("pim")[0]?.value || "");
                let PIM_acumulado = 0; // Para almacenar el último valor de PIM
                let certificado_acumulado = 0; // Para almacenar la resta del último PIM - Saldo

                response.forEach((certificado, index) => {
                    let modificacion = parseFloat(certificado.modificacion) || 0;
                    let monto = parseFloat(certificado.certificacion_monto) || 0;
                    let rebaja = parseFloat(certificado.certificacion_rebaja) || 0;
                    let ampliacion = parseFloat(certificado.certificacion_ampliacion) || 0;

                    PIM = previousPIM + modificacion;
                    Saldo = previousSaldo + modificacion - monto + (rebaja - ampliacion);
                    previousPIM = PIM;
                    previousSaldo = Saldo;

                    if (index === response.length - 1) {
                        PIM_acumulado = PIM;
                        certificado_acumulado = PIM - Saldo;
                    }

                    table.row.add([
                        certificado.codigo_transaccion || "",
                        certificado.fecha,
                        certificado.detalle,
                        modificacion,
                        PIM,
                        monto,
                        rebaja,
                        ampliacion,
                        Saldo,
                        `<button class="btn btn-sm" onclick="editarCertificado('${certificado.id_certificado}', '${certificado.codigo_transaccion}', '${certificado.detalle || ""}', ${modificacion}, ${monto}, ${rebaja}, ${ampliacion}, '${certificado.id_centro_costos || 'null'}')">
                            <i class="fas fa-edit text-success"></i>
                        </button>
                        <button class="btn btn-sm" onclick="eliminarCertificado(${certificado.id_certificado})">
                            <i class="fas fa-trash-alt text-danger"></i>
                        </button>`
                    ]);
                });
                table.order([1, 'asc']);
                table.draw();

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
    function editarCertificado(idCertificado, codigo_transaccion, detalle, modificacion, monto, rebaja, ampliacion, idCentro = null) {
        if (modificacion != 0) {
            // Modo de edición para Nota Modificatoria
            $('#formnota').modal('show');
            $('input[name="mode"]').val('edit'); // Cambia a modo edición
            $('textarea[name="detalle1"]').val(detalle || ''); // Llena el detalle
            $('input[name="notadinero"]').val(modificacion || ''); // Llena el monto de modificación
            $('input[name="id_certificado"]').val(idCertificado); // Llena el ID del certificado
            $('select[name="idCentritos"]').val(idCentro).selectpicker('refresh');

        } else {
            // Modo de edición para Certificado
            $('#formcertificado').modal('show');
            $('input[name="mode"]').val('edit'); // Cambia a modo edición
            $('input[name="certificado"]').val(codigo_transaccion || ''); // Llena el código de certificado
            $('textarea[name="detalle"]').val(detalle || ''); // Llena el detalle
            $('input[name="dinero"]').val(monto || rebaja || ampliacion || ''); // Llena el monto, rebaja o ampliación
            let tipo = monto ? 'monto' : rebaja ? 'rebaja' : 'ampliacion';
            $(`input[name="tipo_certificacion"][value="${tipo}"]`).prop('checked', true);
            $('input[name="id_certificado"]').val(idCertificado); // Llena el ID del certificado
            $('select[name="idCentros"]').val(idCentro).selectpicker('refresh');

        }
    }
</script>