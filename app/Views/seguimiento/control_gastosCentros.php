<!-- JavaScript para manejar la selección del clasificador -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery y DataTables JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<!--begin::Content-->
<!-- Vista controlgastoscentros adaptada -->

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-1">
        <div class="d-flex align-items-baseline flex-wrap mr-5">
          <h5 class="text-dark font-weight-bold my-1 mr-5">Control de Gastos por Centros de Costo</h5>
          <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item">
              <a href="<?= base_url() ?>" class="text-muted">Panel de Control</a>
            </li>
          </ul>
        </div>
      </div>
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
              <option value="<?= esc($clasificador['id_clasificador']) ?>" data-nombre="<?= esc($clasificador['nombre_clasificador']) ?>">
                <?= esc($clasificador['nombre_clasificador']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div id="contenidoPantalla" style="display: none;">
        <!-- Información General -->
        <div class="card shadow-sm mb-4" id="cardInformacionGeneral">
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
              <input type="hidden" name="id_categoria" />
              <input type="hidden" name="id_programa" />
              <input type="hidden" name="id_fuente" />
              <input type="hidden" name="id_meta" />
              <input type="hidden" name="id_clasificador" />
              <input type="hidden" name="id_centro_costos" />
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

           $('input[name="pia"]').val(response.pia || '');
$('input[name="pim"]').val(response.pim || '');

if (response.editable) {
    $('input[name="pia"]').prop('readonly', false);
    $('input[name="pim"]').prop('readonly', false);

    if ($('#btnGuardarInicial').length === 0) {
    const htmlBotonCentrado = `
        <div class="row w-100 mt-4">
            <div class="col-12 text-center">
                <button id="btnGuardarInicial" class="btn btn-outline-primary btn-sm">
                    Guardar Inicialización
                </button>
            </div>
        </div>
    `;
    $('#cardInformacionGeneral .card-body').append(htmlBotonCentrado);
}


    $('#btnGuardarInicial').off('click').on('click', function () {
        const valor_pia = $('input[name="pia"]').val();
        const valor_pim = $('input[name="pim"]').val();

        $.post("<?= base_url('SegDesglose/guardarInicializacion') ?>", {
            id_categoria: categoriaId,
            id_programa: programaId,
            id_fuente: fuenteId,
            id_meta: metaId,
            id_clasificador: clasificadorId,
            id_centro_costos: id_centro_costos,
            valor_pia,
            valor_pim
        }, function (resp) {
            if (resp.success) {
                toastr.success("Inicialización guardada correctamente");
                $('input[name="pia"]').prop('readonly', true);
                $('input[name="pim"]').prop('readonly', true);
                $('#btnGuardarInicial').hide();
            } else {
                toastr.error("Error al guardar inicialización");
            }
        });
    });

} else {
    $('input[name="pia"]').prop('readonly', true);
    $('input[name="pim"]').prop('readonly', true);
    $('#btnGuardarInicial').remove();
}


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