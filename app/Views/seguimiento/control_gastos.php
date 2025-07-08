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
                                <label>Centro de Costo <span class="text-danger">*</span></label>
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
                            <input type="hidden" name="forzarPIMInicial" value="0">

                            <div class="form-group">
                                <label>Centro de Costo <span class="text-danger">*</span></label>
                                <select class="selectpicker form-control" data-live-search="true" id="idCentro" name="idCentro" title="Elije centro de costo">
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
<!-- Modal para ingreso o derivación de PIA -->
<div class="modal fade" id="piaModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿Cómo desea registrar el PIA?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="inputDetalle" name="id_detalle">
        <input type="hidden" id="categoriaPIA">
        <input type="hidden" id="programaPIA">
        <input type="hidden" id="fuentePIA">
        <input type="hidden" id="metaPIA">
        <input type="hidden" id="clasificadorPIA">
        <input type="hidden" name="forzarPIMInicial" value="0">


        <div class="form-group">
          <label>Seleccione una opción:</label>
          <select id="tipoIngresoPIA" class="form-control">
            <option value="">-- Seleccione --</option>
            <option value="directo">Ingresar PIA manualmente</option>
            <option value="nota">Registrar Nota Modificatoria</option>
          </select>
        </div>

        <div class="form-group" id="grupoInputPIA" style="display:none;">
          <input type="number" id="inputPIA" class="form-control" placeholder="Ingrese el valor del PIA">
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" id="guardarPIAOpcion" class="btn btn-primary">Continuar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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

        const clasificadorNombre = $(this).find('option:selected').data('nombre');
        $('input[name="clasificadorNombre"]').val(clasificadorNombre);

        const categoriaId = '<?= $id_categoria ?>';
        const programaId = '<?= $id_programa ?>';
        const fuenteId = '<?= $id_fuente ?>';
        const metaId = '<?= $id_meta ?>';

        $('input[name="id_categoria"]').val(categoriaId);
        $('input[name="id_programa"]').val(programaId);
        $('input[name="id_fuente"]').val(fuenteId);
        $('input[name="id_meta"]').val(metaId);
        $('input[name="id_clasificador"]').val(clasificadorId);

        $('#contenidoPantalla').hide();

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

            $('input[name="pia"]').val(response.pia || '');
            $('input[name="pim"]').val(response.pim || '');

            if (response.pia <= 0 && response.pim == 0.00) {
                $('#inputDetalle').val(response.id_detalle);
                $('#categoriaPIA').val(categoriaId);
                $('#programaPIA').val(programaId);
                $('#fuentePIA').val(fuenteId);
                $('#metaPIA').val(metaId);
                $('#clasificadorPIA').val(clasificadorId);
                $('#piaModal').modal('show');
            } else {
                $('#contenidoPantalla').show();
            }
        });

        // Obtener certificados
        $.post("<?= base_url('SegCarpetas/obtenerCertificados') ?>", {
            id_categoria: categoriaId,
            id_programa: programaId,
            id_fuente: fuenteId,
            id_meta: metaId,
            id_clasificador: clasificadorId,
        }, function(response) {
            const table = $('#kt_datatable').DataTable();
            table.clear();

            let pimInicial = parseFloat(document.getElementsByName("pim")[0]?.value || 0);
            let saldo = pimInicial;
            let PIM_acumulado = 0;
            let certificado_acumulado = 0;

            // Detectar ID del certificado inicial si existe
            const pimInicialCert = response.find(c => parseFloat(c.modificacion) === pimInicial);
            const idInicial = pimInicialCert ? pimInicialCert.id_certificado : null;

            response.forEach((certificado, index) => {
                let modif = parseFloat(certificado.modificacion) || 0;
                let monto = parseFloat(certificado.certificacion_monto) || 0;
                let rebaja = parseFloat(certificado.certificacion_rebaja) || 0;
                let ampliacion = parseFloat(certificado.certificacion_ampliacion) || 0;

                let esPIMInicial = (certificado.id_certificado === idInicial);

                let pim = esPIMInicial ? pimInicial : pimInicial + modif;
                saldo = esPIMInicial ? pimInicial : saldo + modif - monto + (rebaja - ampliacion);

                if (!esPIMInicial) pimInicial = pim; // Acumular solo si no es el inicial

                if (index === response.length - 1) {
                    PIM_acumulado = pim;
                    certificado_acumulado = pim - saldo;
                }

                table.row.add([
                    certificado.codigo_transaccion || "",
                    certificado.fecha,
                    certificado.detalle,
                    modif,
                    pim,
                    monto,
                    rebaja,
                    ampliacion,
                    saldo,
                    `<button class="btn btn-sm" onclick="editarCertificado('${certificado.id_certificado}', '${certificado.codigo_transaccion}', '${certificado.detalle || ""}', ${modif}, ${monto}, ${rebaja}, ${ampliacion}, '${certificado.id_centro_costos || 'null'}')">
                        <i class="fas fa-edit text-success"></i>
                    </button>
                    <button class="btn btn-sm" onclick="eliminarCertificado(${certificado.id_certificado})">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </button>`
                ]);
            });

            table.order([1, 'asc']);
            table.draw();

            // Guardar acumulados
            $.ajax({
                url: "<?= base_url('SegCarpetas/guardarAcumulados') ?>",
                type: "POST",
                data: {
                    id_categoria: categoriaId,
                    id_programa: programaId,
                    id_fuente: fuenteId,
                    id_meta: metaId,
                    id_clasificador: clasificadorId,
                    PIM_acumulado: PIM_acumulado,
                    certificado_acumulado: certificado_acumulado
                },
                success: function(response) {
                    if (!response.success) {
                        alert(response.message);
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
            idCentro: $('select[name="idCentro"]').val() || null,
            forzarPIMInicial: $('input[name="forzarPIMInicial"]').val()

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
                console.log("Formulario:", formData);
                console.log("forzarPIMInicial =", $('input[name="forzarPIMInicial"]').val());

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
            $('select[name="idCentro"]').val(idCentro).selectpicker('refresh');

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

    $('#tipoIngresoPIA').on('change', function () {
  const tipo = $(this).val();
  $('#grupoInputPIA').toggle(tipo === 'directo');
});

$('#guardarPIAOpcion').click(function () {
  const tipo = $('#tipoIngresoPIA').val();
  const idDetalle = $('#inputDetalle').val();

  if (tipo === 'directo') {
    const valorPIA = $('#inputPIA').val();
    if (!valorPIA) {
      alert('Debe ingresar un valor para el PIA');
      return;
    }

    $.post("<?= base_url('SegCarpetas/actualizarPIA') ?>", {
      id_detalle: idDetalle,
      pia: valorPIA
    }, function () {
      $('#piaModal').modal('hide');
      $('#contenidoPantalla').show();
    });

  } else if (tipo === 'nota') {
    const idCategoria = $('#categoriaPIA').val();
    const idPrograma = $('#programaPIA').val();
    const idFuente = $('#fuentePIA').val();
    const idMeta = $('#metaPIA').val();
    const idClasificador = $('#clasificadorPIA').val();

    // Enviar PIA null (opcional, también puede omitirse)
    $.post("<?= base_url('SegCarpetas/actualizarPIA') ?>", {
      id_detalle: idDetalle,
      pia: null
    }, function () {
      $('#piaModal').modal('hide');

      // Asignar valores al modal de nota
      const formNota = $('#form_nota_modificatoria');
      formNota.find('input[name="id_categoria"]').val(idCategoria);
      formNota.find('input[name="id_programa"]').val(idPrograma);
      formNota.find('input[name="id_fuente"]').val(idFuente);
      formNota.find('input[name="id_meta"]').val(idMeta);
      formNota.find('input[name="id_clasificador"]').val(idClasificador);
      formNota.find('input[name="forzarPIMInicial"]').val("1");

      $('#formnota').modal('show');
    });

  } else {
    alert('Seleccione una opción válida');
  }
});

</script>